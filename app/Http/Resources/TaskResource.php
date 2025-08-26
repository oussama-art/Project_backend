<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'assigned_to' => new UserResource($this->whenLoaded('assignedUser')),
            'project'     => new ProjectResource($this->whenLoaded('project')),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
