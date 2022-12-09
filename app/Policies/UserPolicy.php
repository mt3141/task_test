<?php

namespace App\Policies;

use App\Constants\PermissionsConstant;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function listMembers(User $user): bool
    {
        if($user->role == PermissionsConstant::ADMIN){
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function listAdmins(User $user): bool
    {
        if($user->role == PermissionsConstant::ADMIN){
            return true;
        }
        return false;
    }

}
