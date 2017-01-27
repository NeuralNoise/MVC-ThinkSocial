<?php
namespace App\Controllers;
use App\Models\{User, Phone};

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
        $newPhone->phone = $_POST['newPhone'];
        $newPhone->insert();
        header('Location: /profile/show/');
    }


    public function actionDelete()
    {
        Phone::delete($_POST['phoneID']);
        header('Location: /profile/show/');
    }
}
