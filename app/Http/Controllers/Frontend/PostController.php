<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function show($slug){
        
        $post = Post::whereSlug($slug)->first();

        $category = $post->category;

        $posts_belongsto_category = $category->posts()->select('id','slug','title')->limit(5)->get();

        return view('frontend.show-post',compact('post','posts_belongsto_category'));
    }
}
