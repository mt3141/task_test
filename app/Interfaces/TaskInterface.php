<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface TaskInterface
{
    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo;
}
