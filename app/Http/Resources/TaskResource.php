<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $description
 * @property string $title
 * @property integer $user_id
 * @property mixed $user
 * @property mixed $users
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'assignees' => $this->whenLoaded(
                'users',
                function () {
                    return UserResource::collection($this->users);
                }
            )
        ];
    }
}
