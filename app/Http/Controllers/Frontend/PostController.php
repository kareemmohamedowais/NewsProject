<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewCommentNotify;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function show($slug)
    {

        // $MainPost = Post::with([
        //     'comments',
        //     'images' => function ($query) {
        //         $query->latest()->limit(3);
        //     }
        // ])->whereSlug($slug)->first();
        $MainPost = Post::with([
            'images',
            'comments' => fn($q) => $q->latest()->limit(3),
        ])->whereSlug($slug)->firstOrFail();

        // return $MainPost;

        if (!$MainPost) {
            abort(404);
        }

        $category = $MainPost->category;
        $posts_belongsto_category = $category->posts()->active()->select('id', 'slug', 'title')->limit(5)->get();

        $MainPost->increment('num_of_views');
        return view('frontend.show-post', compact('MainPost', 'posts_belongsto_category'));
    }

    // public function GetAllComments($slug)
    // {
    //     $post = Post::whereSlug($slug)->first();
    //     $comments = $post->comments()->with('user')->get();
    //     return response()->json($comments);
    // }

    public function GetAllComments($slug)
{
    $post = Post::whereSlug($slug)->firstOrFail();

    $comments = $post->comments()
        ->with('user')
        ->latest()
        ->get()
        ->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans(),
                'created_date' => $comment->created_at->format('Y-m-d H:i'),
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'image' => $comment->user->image
                        ? asset($comment->user->image)
                        : asset('images/default-user.png'),
                ]
            ];
        });

    if ($comments->isEmpty()) {
        return response()->json([
            'data' => [],
            'msg'  => 'no comments'
        ]);
    }

    return response()->json([
        'data' => $comments,
        'msg'  => 'contain comments'
    ]);
}


//         public function getComments($id)
// {
//     $comments = Comment::with('user')
//         ->where('post_id', $id)
//         ->latest()
//         ->get()
//         ->map(function($comment){
//             return [
//                 'id' => $comment->id,
//                 'comment' => $comment->comment,
//                 'created_at' => $comment->created_at->diffForHumans(),
//                 'created_date' => $comment->created_at->format('Y-m-d H:i'),
//                 'user' => [
//                     'id' => $comment->user->id,
//                     'name' => $comment->user->name,
//                     'image' => $comment->user->image
//                         ? asset($comment->user->image)
//                         : asset('images/default-user.png'),
//                 ]
//             ];
//         });

//     if ($comments->isEmpty()) {
//         return response()->json([
//             'data' => [],
//             'msg'  => 'no comments'
//         ]);
//     }

//     return response()->json([
//         'data' => $comments,
//         'msg'  => 'contain comments'
//     ]);
// }

    public function StoreComment(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'comment' => ['required', 'string', 'max:200'],
        ]);
        //     $validated = $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'comment' => 'required|string|max:200',
        // ]);

        $comment = Comment::create([
            'user_id' => auth()->id(), // المستخدم الحالي
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'ip_address' => $request->ip(),
        ]);

        $post = Post::findOrFail($request->post_id);
        $user = $post->user;

        // امنع الإشعار لو صاحب الكومنت هو نفسه صاحب البوست
        if (auth()->id() != $user->id) {
            $user->notify(new NewCommentNotify($comment, $post));
        }

        // sent to a group of users
        // $users = User::where('id','!=',auth()->user()->id)->get();
        // foreach ($users as $user) {
        //         $user->notify(new NewCommentNotify($comment, $post));
        // }
        // sent to a group of users 2
        // Notification::send($users, new NewCommentNotify($comment, $post));




        $comment->load('user');

        if (!$comment) {
            return response()->json([
                'data' => 'failed',
                'status' => 403,

            ]);
        }
        $formattedComment = [
        'id' => $comment->id,
        'comment' => $comment->comment,
        'created_at' => $comment->created_at->diffForHumans(),
        'created_date' => $comment->created_at->format('Y-m-d H:i'),
        'user' => [
            'id' => $comment->user->id,
            'name' => $comment->user->name,
            'image' => $comment->user->image
                ? asset($comment->user->image)
                : asset('images/default-user.png'),
        ]
    ];
        return response()->json([
            'msg' => 'sucess store',
            'comment' => $formattedComment,
            'status' => 201,
        ]);

    }
}
