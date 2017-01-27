<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Group extends ActiveRecord
{
    const GROUP_NAME_LENGTH = 20;
    const GROUP_DESC_LENGTH = 255;
    public $name;
    public $description;
    public $status;
    protected static $tableName = 'groups';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'name' => 'name',
                                     'description' => 'description',
                                     'status' => 'status',
                                    ];

    /**
     * Group constructor.
     */
    public function __construct()
    {
            $this->status = 'active';
    }
}
