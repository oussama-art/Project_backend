<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'owner'       => new UserResource($this->whenLoaded('user')), // relation
            'tasks'       => TaskResource::collection($this->whenLoaded('tasks')), // collection
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
