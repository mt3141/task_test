<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * @param string $role
     * @return LengthAwarePaginator
     */
    public function list(string $role): LengthAwarePaginator
    {
        return $this->query->whereRole($role)->paginate();
    }

}
