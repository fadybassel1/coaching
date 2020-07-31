<?php

namespace App\Policies;

use App\User;
use App\models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function post(User $user, Group $group)
    {
        return $user->groups->contains($group->id);
    }

}
