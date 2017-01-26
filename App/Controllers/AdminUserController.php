<?php

namespace App\Controllers;

use App\Components\AdminBase;
use App\Models\Password;
use App\Models\User;

class AdminUserController extends PageController
{
    use AdminBase;
    /**
     * Action for page "User Management"
     */
    public function actionIndex()
    {
        User::joinDB('users.id', 'users_avatars', 'user_id', ['id' => 'userAvatarId', 'file_name' => 'avatarFileName'],true);

        $users = User::getAll();

        return ['templateNames' => ['/admin_user/index'],
        'users' => $users
        ];
    }


    /**
     * Action for page "Edit user"
     */
    public function actionUpdate($id)
    {
        self::checkAdmin();

        $errors = false;

        User::join('id', 'App\Models\Password', 'userId');
        $user = User::getByID($id);

        if (isset($_POST['submit'])) {

            $user->firstName = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password[0]->password = $_POST['password'];


            if (!User::checkName($user->firstName)) {
                $errors['firstName'] = 'Incorrect First Name';
            }
            if (!User::checkEmail($user->email)) {
                $errors['email'] = 'Incorrect email';
            }
            if (!User::checkPassword($user->password[0]->password)) {
                $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                $user->update();
                //$user->password[0]->update();
                print_r($user);exit;
                header("Location: /admin/task");
            }


        }

        return ['templateNames' => ['/admin_user/update'],
            'user' => $user,
            'errors' => $errors
        ];
    }

    /**
     * Action for page "Delete task"
     */
    public function actionDelete($id)
    {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
            User::delete($id);

            header("Location: /admin/task");
        }

        return ['templateNames' => ['/admin_user/delete'],
               'id' =>$id
        ];
    }
}