<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 1/8/17
 * Time: 4:29 PM
 */

namespace App\DataMapperModels;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class UserDM
{
    public $id;

    public $firstName;

    public $middleName;

    public $lastName;

    public $email;

    public $birthday;

    public $sex;

    public $status;

    //protected $session;

    public function __construct($id, $firstName, $middleName, $lastName, $email, $birthday, $sex, $status)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->sex = $sex;
        $this->status = $status;
    }
}
