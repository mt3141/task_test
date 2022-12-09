<?php

namespace App\Interfaces;

use App\Task;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    /**
     * @param UserInterface $user
     * @return Task
     */
    public function attachUser(UserInterface $user): Task;

    /**
     * @param UserInterface $user
     * @return LengthAwarePaginator
     */
    public function list(UserInterface $user): LengthAwarePaginator;

    /**
     * @param Task $task
     * @param UserInterface $user
     * @return Task
     */
    public function assignToMe(Task $task, UserInterface $user): Task;
}
