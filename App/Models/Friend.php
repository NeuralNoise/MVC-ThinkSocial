<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Friend extends ActiveRecord
{
    protected static $tableName = 'friends';
    protected static $tableFields = ["id" => "id",
        "user_sender" => "userSender",
        "user_receiver" => "userReceiver",
        "status" => "status",
    ];
}
