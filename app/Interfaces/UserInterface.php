<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface UserInterface
{
    /**
     * @return mixed
     */
    public function getJWTIdentifier();

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;
}
