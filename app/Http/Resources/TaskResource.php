<?php

namespace App\Http\Resources;

use App\Entities\TaskEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TaskEntity $resource
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
            'due_date' => $this->resource->due_date->toDateString(),
            'status' => $this->resource->status->value,
            'created_at' => $this->resource->created_at->toDateTimeString(),
            'updated_at' => $this->resource->updated_at->toDateTimeString(),
            'assigned_user' => $this->when(
                !is_null($this->resource->assignedUser),
                new UserResource($this->resource->assignedUser),
                null
            )
        ];
    }
}