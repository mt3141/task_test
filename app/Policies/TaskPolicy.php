<?php

namespace App\Policies;

use App\Constants\PermissionsConstant;
use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Task $task
     * @return mixed
     */
    public function update(User $user, Task $task):bool
    {
        if ($user->role == PermissionsConstant::ADMIN || $user->id == $task->user_id) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return mixed
     */
    public function delete(User $user, Task $task):bool
    {
        if ($user->role == PermissionsConstant::ADMIN || $user->id == $task->user_id) {
            return true;
        }
        return false;
    }

}
