<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    /**
     * @param string $role
     * @return LengthAwarePaginator
     */
    public function list(string $role): LengthAwarePaginator;
}
