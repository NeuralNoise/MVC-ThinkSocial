<?php
namespace App\Components;

use App\Models\{User,UserRole};

/**
 * Trait AdminBase contains general logic controllers, which
 * used in the admin panel
 */
trait AdminBase
{
    /**
     * The method that checks the user of the fact whether it is the administrator
     * @return boolean
     */
    public static function checkAdmin()
    {
        $userId = User::checkLogged();
        UserRole::joinDB('users_roles.role_id', 'roles', 'id', [ 'name' => 'roleName']);
        $userRoles = UserRole::getByCondition(['userId' => $userId]);
         foreach ($userRoles as $userRole) {
            if ($userRole->roleName == 'admin') {
                return true;
            }
         }
        die('Access denied');
    }

}
