<?php
namespace App\Controllers;

use App\Models\{User, Phone, UserAvatar};

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */
class ProfileController extends PageController
{


    public function actionShow()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Profile';
        $result['submitAction'] = 'edit';
        $result['submitValue'] = 'Edit profile';
        $result['submitPhoneAction'] = 'input';
        $result['submitPhoneValue'] = 'Add phone';
        $result['allowEdit'] = 'disabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);
        return $result;
    }


    public function actionEdit()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Changing profile';
        $result['submitAction'] = 'update';
        $result['submitValue'] = 'Submit';
        $result['submitPhoneAction'] = 'input';
        $result['submitPhoneValue'] = 'Add phone';
        $result['allowEdit'] = 'enabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);
        return $result;
    }


    public function actionInput()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Adding phone';
        $result['submitAction'] = 'edit';
        $result['submitValue'] = 'Edit profile';
        $result['submitPhoneAction'] = 'insert';
        $result['submitPhoneValue'] = 'OK';
        $result['allowEdit'] = 'disabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);
        return $result;
    }


    public function actionUpdate()
    {
        $this->userId = User::checkLogged();
        $user = User::getByID($this->userId);
        foreach ($_POST as $field => $value) {
            $user->{$field} = htmlentities($value);
        }
        $user->update();
        header('Location: /profile/show/');
    }


    public function actionInsert()
    {
        $this->userId = User::checkLogged();
        $newPhone = new Phone();
        $newPhone->userId = $this->userId;
        $newPhone->phone = htmlentities($_POST['newPhone']);
        $newPhone->insert();
        header('Location: /profile/show/');
    }


    public function actionDelete()
    {
        Phone::delete($_POST['phoneID']);
        header('Location: /profile/show/');
    }


    public function actionUpload()
    {
        $this->userId = User::checkLogged();
        if (!isset($_FILES['fileName'])) {
            throw new \Exception('Photo required');
        }
        $this->fileValidation(0);
        $path = ROOT . '/public/avatars/';
        $ext = explode('.', $_FILES['fileName']['name']);
        $newName = md5(time() . $ext[0]) . '.' . $ext[1];
        $full_path = $path . $newName;
        if (!move_uploaded_file($_FILES['fileName']['tmp_name'], $full_path)) {
            header('Location: /profile/show/');
        }
        $avatar = UserAvatar::getByCondition(['userId' => $this->userId]);
        if (!isset($avatar)) {
            $avatar = new UserAvatar();
            $avatar->userId = $this->userId;
            $avatar->fileName = $newName;
            $avatar->status = 'active';
            $avatar->insert();
        } else {
            $avatar->fileName = $newName;
            $avatar->status = 'active';
            $avatar->update();
        }
        header('Location: /profile/show/');
    }


    private function fileValidation($i)
    {
        $size = 1024 * 3 * 1024;//3 Mb
        $allowedExts = ['jpg', 'jpeg', 'gif', 'png'];
        $ext = explode('.', $_FILES['fileName']['name']);
        if ($_FILES['fileName']['size'] > $size
            || $_FILES['fileName']['error'] != 0
            || !in_array(end($ext), $allowedExts)
        ) {
            throw new \Exception('Size > 3 Mb OR some error occurred OR unsupported format');
        }
    }
}