<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewCommentNotify;

class PostController extends Controller
{
    public function show($slug)
    {

        $MainPost = Post::with(['comments'=>function($query){
            $query->latest()->limit(3);
        }])->whereSlug($slug)->first();

        $category = $MainPost->category;
        $posts_belongsto_category = $category->posts()->active()->select('id', 'slug', 'title')->limit(5)->get();

        $MainPost->increment('num_of_views');
        return view('frontend.show-post', compact('MainPost', 'posts_belongsto_category'));
    }

    public function GetAllComments($slug){
        $post = Post::whereSlug($slug)->first();
        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function StoreComment(Request $request){
        $request->validate([
            'user_id'=>['required','exists:users,id'],
            'comment'=>['required','string','max:200'],
        ]);
    //     $validated = $request->validate([
    //     'user_id' => 'required|exists:users,id',
    //     'comment' => 'required|string|max:200',
    // ]);

        $comment = Comment::create([
            'user_id'=>$request->user_id,
            'comment'=>$request->comment,
            'post_id'=>$request->post_id,
            'ip_address'=>$request->ip(),
        ]);

        // new comment notification
        $post = Post::findOrFail($request->post_id);
        $user = $post->user;
        $user->notify(new NewCommentNotify($comment,$post));

        $comment->load('user');

        if(!$comment){
            return response()->json([
                'data'=>'failed',
                'status'=>403,

            ]);
        }
        return response()->json([
            'msg'=>'sucess store',
            'comment'=>$comment,
            'status'=>201,
        ]);

    }
}
