<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray($request)
    {
        return [
            'message'    => $this->resource['message'] ?? null,
            'user'       => new UserResource($this->resource['user']),
            'token_type' => 'Bearer',
            'token'      => $this->resource['token'],
        ];
    }
}
