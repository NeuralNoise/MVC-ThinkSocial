<?php

namespace App\Models\Groups\Managers;

use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\GroupsAvatars;
use App\Models\Groups\Butler;

/**
 * Class GroupManager
 * @package App\Models\Groups\Managers
 */

class GroupManager
{
    private $butler;

    /**
     * GroupManager constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * On success returns new Group Instance else returns false
     * @return Group|bool
     */
    public function addGroup()
    {
        try {
            $userGroup = new UserGroup();
            $avatar = new GroupsAvatars();
            $userGroup->userId = $this->butler['CurrentUser'];
            $group = new Group();
            $group->name = $this->butler['InputFilter']->clearStr($_POST['group-name']);
            $group->description = $this->butler['InputFilter']->clearStr($_POST['description']);
            $userGroup->roleId = 4;
            $group->insert();
            if (empty($group->id)) {
                return false;
            } else {
                $userGroup->groupId = $group->id;
                $avatar->groupId = $group->id;
                $avatar->fileName = GroupsAvatars::DEFAULT_AVATAR_PIC;
                $userGroup->insert();
                $avatar->insert();
                return $group;
            }
        } catch (\Throwable $ex) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function subscribe()
    {
        $userGroup = new UserGroup();
        $userGroup->userId = $this->butler['CurrentUser'];
        $userGroup->groupId = $this->butler['CurrentGroup']->id;
        $userGroup->roleId = UserGroup::USER_GROUP_SUBSCRIBER;
        $userGroup->insert();
        if ($userGroup->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function unSubscribe()
    {
        $userGroup = $this->butler['UserGroup'];
        $userGroup->delete($userGroup->id);
        $this->butler['UserGroup'] = null;
        return true;
    }

    public function saveAvatar()
    {
        try {
            $path = "avatars";
            $id = $this->butler['CurrentGroup']->id;
            $name = str_replace(" ", "_", $this->butler['CurrentGroup']->name);
            $ext = $this->butler['InputFilter']->getFileExtension();
            $imageName =  $id . "_" . $name . "_" . "Avatar" . "." . $ext;
            $fullPath = $path . DIRECTORY_SEPARATOR . $imageName;
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $fullPath)) {
                throw new \Exception('Error');
            } else {
                $avatar = GroupsAvatars::getByCondition(['groupId' => $id])[0];
                $avatar->fileName = $imageName;
                $avatar->update();
                return DIRECTORY_SEPARATOR . $fullPath;
            }
        } catch (\Throwable $err) {
            return false;
        }
    }

    public function userGroupsSearch()
    {
        $search = $this->butler['InputFilter']->clearStr($_POST['search']);
        $valid = $this->butler['InputFilter']->checkStrLen($search, Group::GROUP_NAME_LENGTH);
        if ($valid) {
            UserGroup::clearJoins();
            UserGroup::clearJoinsDB();
            UserGroup::join('groupId', 'App\Models\Group', 'id');
            UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
            $myGroups = UserGroup::getByCondition(
                ['userId' => $this->butler['CurrentUser'], 'roleId' => UserGroup::USER_GROUP_OWNER],
                " AND group_id IN (SELECT id FROM groups WHERE name LIKE '%{$search}%')"
            );
            $forignGroups = UserGroup::getByCondition(
                ['userId' => $this->butler['CurrentUser'], 'roleId' => UserGroup::USER_GROUP_SUBSCRIBER],
                " AND group_id IN (SELECT id FROM groups WHERE name LIKE '%{$search}%')"
            );
            $result = [];
            foreach ($myGroups as $myGroup) {
                $result['owner'][$myGroup->groupId]['name'] = $myGroup->group->name;
                $result['owner'][$myGroup->groupId]['desc'] = $myGroup->group->description;
                $result['owner'][$myGroup->groupId]['photo'] = $myGroup->groupsAvatars[0]->fileName;
            }
            foreach ($forignGroups as $myGroup) {
                $result['subscriber'][$myGroup->groupId]['name'] = $myGroup->group->name;
                $result['subscriber'][$myGroup->groupId]['desc'] = $myGroup->group->description;
                $result['subscriber'][$myGroup->groupId]['photo'] = $myGroup->groupsAvatars[0]->fileName;
            }
            return $result;
        } else {
            return [];
        }
    }

    public function groupsSearch()
    {
        $search = $this->butler['InputFilter']->clearStr($_POST['search']);
        $valid = $this->butler['InputFilter']->checkStrLen($search, Group::GROUP_NAME_LENGTH);
        if ($valid) {
            UserGroup::clearJoins();
            UserGroup::clearJoinsDB();
            UserGroup::join('groupId', 'App\Models\Group', 'id');
            UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
            $Groups = UserGroup::getByDirectSQL(
                ['userId' => $this->butler['CurrentUser'],],
                "SELECT distinct group_id as groupId FROM users_groups 
                    WHERE user_id <> :userId AND group_id NOT IN 
                          (SELECT group_id FROM users_groups WHERE user_id = :userId) AND 
                          group_id IN (SELECT id FROM groups WHERE name LIKE '%{$search}%')"
            );
            $result = [];
            foreach ($Groups as $Group) {
                $result['new'][$Group->groupId]['name'] = $Group->group->name;
                $result['new'][$Group->groupId]['desc'] = $Group->group->description;
                $result['new'][$Group->groupId]['photo'] = $Group->groupsAvatars[0]->fileName;
            }
            return $result;
        } else {
            return [];
        }
    }
}
