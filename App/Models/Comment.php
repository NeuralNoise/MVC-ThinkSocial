<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Comment extends ActiveRecord
{
    protected static $tableName = 'comments';
    protected static $tableFields = [
                                        'id' => 'id',
                                        'user_id' => 'userId',
                                        'text' => 'text',
                                        'created_at' => 'created_at',
                                        'status' => 'status',
                                    ];
}
