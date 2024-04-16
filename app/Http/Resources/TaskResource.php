<?php

namespace App\Http\Resources;

use App\Responses\TaskResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TaskResponse $resource
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'due_date' => $this->resource->dueDate->toDateString(),
            'status' => $this->resource->status->value,
            'created_at' => $this->resource->createdAt->toDateTimeString(),
            'updated_at' => $this->resource->updatedAt->toDateTimeString(),
            'assigned_user_id' => $this->resource->assignedUserId,
            'assigned_user' => $this->when(
                !is_null($this->resource->assignedUser),
                new UserResource($this->resource->assignedUser),
                null
            )
        ];
    }
}
