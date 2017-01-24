<?php
namespace App\Models\Groups\Validators;

use App\Models\Group;
use App\Models\Groups\Butler;
use App\Models\GroupsAvatars;

/**
 * Class GroupValidator
 * @package App\Models\Groups\Validators
 */
class GroupValidator
{
    private $butler;
    private $group;
    private $avatar;

    /**
     * GroupValidator constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * @return bool
     */
    public function isExists()
    {
        if (!$this->butler['GroupKey']) {
            return false;
        } else {
            $this->group = Group::getByCondition(['id' => $this->butler['GroupKey']]);
            $this->avatar = GroupsAvatars::getByCondition(['groupId' => $this->butler['GroupKey']]);
            if (empty($this->group) or empty($this->avatar)) {
                return false;
            } else {
                $this->cache();
                return true;
            }
        }
    }

    private function cache()
    {
        $this->butler['CurrentGroup'] = $this->group[0];
        $this->butler['CurrentAvatar'] = $this->avatar[0];
        if ($this->butler['CurrentAvatar']->fileName != GroupsAvatars::DEFAULT_AVATAR_PIC) {
            $this->butler['GroupHasAvatar'] = true;
        } else {
            $this->butler['GroupHasAvatar'] = false;
        }
    }
}
