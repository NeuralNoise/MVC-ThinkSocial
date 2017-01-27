<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/25/16
 * Time: 10:58 AM
 */

namespace App\DataMapperModels;

use App\Components\AbstractDataMapper;
use \App\DataMapperModels\UserDM;

class UserMapper extends AbstractDataMapper
{
    protected $entityTable = "users";

    public function insert(UserDM $user)
    {
        $user->id = $this->adapter->insert(
            $this->entityTable,
            array("first_name"  => $user->firstName,
                "middle_name" => $user->middleName,
                "last_name" => $user->lastName,
                "email" => $user->email,
                "birthday" => $user->birthday,
                "sex" => $user->sex,
                "status" => $user->status
            )
        );
        return $user->id;
    }

    public function checkUserData($email, $password)
    {
        $this->adapter->select(
            $this->entityTable,
            array('email' => $email,
                'password' => $password
            )
        );

        if (!$row = $this->adapter->fetch()) {
            return null;
        }

        return $this->createEntity($row);
    }

    public function delete($id)
    {
        if ($id instanceof UserDM) {
            $id = $id->id;
        }

        return $this->adapter->delete($this->entityTable, array("id = $id"));
    }

    protected function createEntity(array $row)
    {
        return new UserDM(
            $row["id"],
            $row["first_name"],
            $row["middle_name"],
            $row["last_name"],
            $row["email"],
            $row["birthday"],
            $row["sex"],
            $row["status"]
        );
    }

}