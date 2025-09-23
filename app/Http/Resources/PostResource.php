<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'num_of_views'=>$this->num_of_views,
            'status'=>$this->status(),
            'date' => $this->created_at->format('Y-m-d'),
            'category_name'=>$this->category->name,
            'media'=>ImageResource::collection($this->images),
            // 'post-url'=>route('frontend.post.show',$this->slug),
            // 'post-endpoint'=>url('api/post/'.$this->slug),

            // 'comment_able'=>$this->comment_able == 1 ? 'active' : 'inactive',
            // 'category'=>CategoryResource::make($this->category),
            // 'publisher'=>$this->user_id == null ? new AdminResource($this->admin) :new UserResource($this->user),
            'publisher'=>$this->user->name  ?? $this->admin->name,
            // 'user'=>UserResource::make($this->user),
            // 'admin'=>AdminResource::make($this->admin),
        ];

        if($request->is('api/posts/show/*')){
            $data['category']=CategoryResource::make($this->category);
            // $data['comments']=new CommentCollection($this->comments);
            // هعمل للكومن ايند بوينت خاصه بيها
            $data['comment_able']=$this->comment_able == 1 ? 'active' : 'inactive';
            $data['desc']=$this->desc;
        }


        return $data;
    }
}
