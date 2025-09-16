<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // هنا هنخلي الفلتره للداتا في ال PostResource
            // 'posts'=>$this->collection,  لازم يكون نفس الاسم
            'posts'=>PostResource::collection($this->collection), // لو الاسم متغير
            // هنا هنفلتر الداتا في ال PostCollection
            // 'posts'=>$this->collection->map(function($post){
            //     return [
            //         'title'=>$post->title,
            //         'slug'=>$post->slug,
            //     ];
            // }),

            // meta data for collection here
            'count'=>$this->count(),
            'desc'=>'collection of posts',

        ];
    }
}
