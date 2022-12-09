<?php

namespace App\Traits;

trait RequestValidationTrait
{
    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function password(array $rules = []): array
    {
        return array_merge(
            [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function username(array $rules = []): array
    {
        return array_merge(
            ['required', 'string', 'min:4'],
            $rules
        );
    }

}
