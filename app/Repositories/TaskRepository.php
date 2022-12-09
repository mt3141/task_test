<?php

namespace App\Repositories;

use App\Constants\PermissionsConstant;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserInterface;
use App\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Builder;

class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Task::class;
    }

    /**
     * @param UserInterface $user
     * @return Task
     */
    public function attachUser(UserInterface $user): Task
    {
        $this->model->users()->attach($user);

        return $this->model;
    }

    /**
     * @param UserInterface $user
     * @return LengthAwarePaginator
     */
    public function list(UserInterface $user): LengthAwarePaginator
    {
        return $this->query->when(
            $user->role == PermissionsConstant::MEMBER,
            function (Builder $builder) use ($user) {
                return $builder->whereUserId($user->id);
            })
            ->with('users')
            ->paginate();
    }

    /**
     * @param Task $task
     * @param UserInterface $user
     * @return Task
     */
    public function assignToMe(Task $task, UserInterface $user): Task
    {
        if (! $task->users->contains($user->id)) {
            $task->users()->attach($user->id);
        }

        return $task;
    }

}
