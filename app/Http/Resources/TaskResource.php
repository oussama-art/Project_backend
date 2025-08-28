<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'assigned_to' => new UserResource($this->whenLoaded('assignedUser')),
            'project_id'  => $this->project_id, 
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
