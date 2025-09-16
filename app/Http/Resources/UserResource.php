<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user-name'=>$this->name,
            // 'user-status'=>$this->status(),
            // 'created-date'=>$this->created_at->diffForHumans(),
        ];
    }
}
