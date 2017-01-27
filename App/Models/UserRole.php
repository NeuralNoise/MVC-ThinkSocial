<?php
namespace App\Models;

use App\Components\ActiveRecord;



class UserRole extends ActiveRecord
{
    protected static $tableName = 'users_roles';
    protected static $tableFields = [
        'id' => 'id',
        'user_id' => 'userId',
        'role_id' => 'roleId',
    ];
}
