<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 25.01.17
 * Time: 13:29
 */

namespace App\Controllers;

use App\Models\User;

use \App\DataMapperModels\DialogMapper;
use \App\DataMapperModels\Dialogs;
use \App\DataMapperModels\FriendMapper;
use \App\DataMapperModels\Message;
use \App\DataMapperModels\MessageMapper;
use \App\DataMapperModels\Recipient;
use \App\DataMapperModels\RecipientMapper;
use \App\DataMapperModels\UserMapper;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class DialogController extends PageController implements MessageComponentInterface
{
    protected $clients;

    public $templator;

    public function __construct()
    {
        $this->clients = [];
    }

    /* Ratchet actions */

    /**
     * Метод вызывается при выполнении подключения
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        //сохраняем новое подключение
        $conn->Session->start();
        $this->clients[$conn->Session->get('user')] = $conn;


        echo "User: " . $conn->Session->get('user') . " connected\n";
        //print_r($conn->Session);
    }

    /**
     * Метод вызывается при отправке сообщения
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo $msg;
        $message = json_decode($msg, true);
        $messageEntity = new Message($message['userId'], $message['roomId'], $message['text']);
        $messageMapper = new MessageMapper();
        $messageMapper->insert($messageEntity);
        $recipientMapper = new RecipientMapper();
        $recipients = $recipientMapper->findAll(['dialog_room_id' => $message['roomId']]);
        foreach ($recipients as $recipient) {
            if (isset($this->clients[$recipient->userId])) {
                if ($from !== $this->clients[$recipient->userId]) {
                    $recipientMapper->addUnreadCounter($recipient->userId, $recipient->dialogId);
                    $this->clients[$recipient->userId]->send($msg);
                }
            } else {
                $recipientMapper->addUnreadCounter($recipient->userId, $recipient->dialogId);
            }
        }
    }

    /**
     * Метод вызывается при закрытии подключения
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->Session->get('uid')]);
        echo "User " . $conn->Session->get('uid') . " has disconnected\n";
    }

    /**
     * Метод вызывается при ошибке подключения
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    /*Origin actions*/


    public function actionShow()
    {
        if ($id = User::checkLogged()) {
            $friendMapper = new FriendMapper();
            $friends = $friendMapper->getFriends($id);

            $dialogMapper = new DialogMapper();
            $dialogs = $dialogMapper->getDialogs($id);

            $messages = [];
            $users = [];
            $dialogRecipients = [];
            $unreadCounter = 0;
            $recipientMapper = new RecipientMapper();
            $userMapper = new UserMapper();
            $messageMapper = new MessageMapper();

            foreach ($dialogs as $dialog) {
                $messages[$dialog->id] = $messageMapper->findAll(['dialog_room_id' => $dialog->id]);
                $dialogRecipients[$dialog->id] = $recipientMapper->findAll(['dialog_room_id' => $dialog->id]);

                foreach ($dialogRecipients[$dialog->id] as $dialogRecipient) {
                    $users[$dialog->id][$dialogRecipient->userId] = $userMapper->findById($dialogRecipient->userId);
                    if ($id == $dialogRecipient->userId) {
                        $unreadCounter += $dialogRecipient->unreadCounter;
                    }
                }
            }

            $loggedUser = $userMapper->findById($id);

        } else {
            header("Location: user/login ");
        }

        $this->templator = parent::actionIndex();
        $this->templator['templateNames'] = [
            '/dialogs/headDialogs',
            'navbar',
            '/dialogs/dialogs',
            'rightcolumn',
            'footer',
            ];
        $this->templator['loggedUser'] = $loggedUser;
        $this->templator['friends'] = $friends;
        $this->templator['dialogs'] = array_reverse($dialogs);
        $this->templator['messages'] = $messages;
        $this->templator['dialogRecipients'] = $dialogRecipients;
        $this->templator['users'] =  $users;
        $this->templator['unreadCounter'] =  $unreadCounter;

        return  $this->templator;
    }

    /* jquery ajax actions */

    public function actionClearUnreadCounter()
    {
        $recipientMapper = new RecipientMapper();
        if ($id = User::checkLogged()) {
            if (isset($_POST['clearUnread'])) {
                $recipientMapper->clearUnreadCounter($id, $_POST['roomId']);
            }
        } else {
            header("Location: /login ");
        }
    }

    public function actionAddUnreadCounter()
    {
        $recipientMapper = new RecipientMapper();
        if ($id = User::checkLogged()) {
            $recipient = $recipientMapper->findAll([
                'user_id' => $_POST['userId'],
                'dialog_room_id' => $_POST['dialogId']
            ]);
            echo json_encode(
                ["unreadCounter" => $recipient[0]->unreadCounter]
            );
            exit();
        } else {
            header("Location: user/login ");
        }
    }

    public function actionCreateDialog()
    {
        $dialogMapper = new DialogMapper();
        $recipientMapper = new RecipientMapper();
        if ($id = User::checkLogged()) {
            if (isset($_POST)) {
                $dialog = new Dialogs($_POST['dialogName'], $id);
                $dialog->id  = $dialogMapper->insert($dialog);
                $recipient = new Recipient($id, $dialog->id);
                $recipientMapper->insert($recipient);
                foreach ($_POST['friendIds'] as $userId) {
                    $recipient = new Recipient($userId, $dialog->id);
                    $recipientMapper->insert($recipient);
                }
                echo $dialog->id;
                exit();
            }
        } else {
            header("Location: user/login ");
        }
    }

    public function actionUser()
    {
        if ($id = User::checkLogged()) {
            $userMapper = new UserMapper();
            $user = $userMapper->findById($id);
            echo json_encode(
                array("id" => $user->id,
                    "firstName"  => $user->firstName,
                    "middleName" => $user->middleName,
                    "lastName" => $user->lastName
                )
            );
            exit();
        } else {
            header("Location: user/login ");
        }
    }
}
