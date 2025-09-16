<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'category-name'=>$this->name,
            'category-slug'=>$this->slug,
            'category-status'=>$this->status(),
            'created-date'=>$this->created_at->format('Y-m-d'),
            // 'posts'
        ];
        if(!$request->is('api/posts/show/*')){
            $data['posts']=  PostResource::collection($this->posts);
        }
        return $data;
    }
}
