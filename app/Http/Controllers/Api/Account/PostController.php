<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\Post;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PostCollection;
use App\Http\Resources\CommentResource;
use App\Notifications\NewCommentNotify;

class PostController extends Controller
{
    public function getPosts()
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    $posts = $user->posts()
        ->active()
        ->activeCategory()
        ->latest()
        ->get();

    if ($posts->isEmpty()) {
        return apiResponse(404, 'No posts found for this user');
    }

    return apiResponse(200, 'User posts retrieved successfully', new PostCollection($posts));
}

    public function storeUserPost(PostRequest $request)
{
    try {
        DB::beginTransaction();

        // أنشئ البوست من المستخدم الحالي
        $post = $request->user()->posts()->create(
            $request->safe()->except(['images']) // استخدم safe() عشان ناخد بس البيانات المتحققة
        );

        // ارفع الصور لو موجودة
        if ($request->hasFile('images')) {
            ImageManager::uploadImages($request, $post);
        }

        DB::commit();

        // امسح الكاش المرتبط
        Cache::forget('read_more_posts');
        Cache::forget('latest_posts');

        return apiResponse(201, 'Post created successfully', [
            'post_slug' => $post->slug, // رجع ID البوست الجديد لو تحب
        ]);

    } catch (\Throwable $e) {
        DB::rollBack(); // مهم عشان الـ rollback
        Log::error('Error while storing user post', [
            'user_id' => $request->user()->id,
            'error'   => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return apiResponse(500, 'Something went wrong, please try again later.');
    }
}

public function updateUserPost(PostRequest $request, $post_id)
{
    try {
        DB::beginTransaction();
        $user = auth('sanctum')->user();
        if (!$user) {
            return apiResponse(401, 'Unauthenticated');
        }
        $post = $user->posts()->find($post_id);
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }
        $post->update($request->except(['images', '_method']));
        if ($request->hasFile('images')) {
            ImageManager::deleteImages($post);
            ImageManager::uploadImages($request, $post);
        }
        DB::commit();
        return apiResponse(200, 'Post updated successfully');
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error updating user post: ' . $e->getMessage(), [
            'user_id' => auth('sanctum')->id(),
            'post_id' => $post_id,
            'trace'   => $e->getTraceAsString()
        ]);
        return apiResponse(500, 'Something went wrong, please try again later');
    }
}

public function destroyUserPost($post_id)
{
    $user = auth()->user();

    try {
        DB::beginTransaction();

        $post = $user->posts()->findOrFail($post_id);

        // امسح الصور المرتبطة
        ImageManager::deleteImages($post);

        // امسح البوست نفسه
        $post->delete();

        DB::commit();

        // امسح الكاش (لو موجود)
        Cache::forget('read_more_posts');
        Cache::forget('latest_posts');

        return apiResponse(200, 'Post deleted successfully');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollBack();
        return apiResponse(404, 'Post not found');

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error deleting user post', [
            'user_id' => $user->id,
            'post_id' => $post_id,
            'error'   => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);
        return apiResponse(500, 'Something went wrong, please try again later.');
    }
}

public function getPostComments($post_id)
{
    $user = auth('sanctum')->user();
    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }
    $post = $user->posts()->find($post_id);
    if (!$post) {
        return apiResponse(404, 'Post not found');
    }
    $comments = $post->comments()->latest()->get();
    if ($comments->isEmpty()) {
        return apiResponse(404, 'No comments found for this post');
    }
    return apiResponse(200, 'Comments retrieved successfully', CommentResource::collection($comments));
}

public function storeComment(CommentRequest $request)
{
    try {
        DB::beginTransaction();
        $user = auth('sanctum')->user();
        if (!$user) {
            return apiResponse(401, 'Unauthenticated');
        }
        $post = Post::find($request->post_id);
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }
        $comment = $post->comments()->create([
            'user_id'   => $user->id,
            'comment'   => $request->comment,
            'ip_address'=> $request->ip(),
        ]);
        if (!$comment) {
            DB::rollBack();
            return apiResponse(400, 'Failed to create comment, please try again');
        }
        // لو الكومنت مش من صاحب البوست → ابعت نوتيفيكيشن
        if ($user->id !== $post->user_id) {
            $post->user->notify(new NewCommentNotify($comment, $post));
        }
        DB::commit();
        return apiResponse(201, 'Comment created successfully');
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error creating comment: ' . $e->getMessage(), [
            'user_id' => auth('sanctum')->id(),
            'post_id' => $request->post_id,
            'trace'   => $e->getTraceAsString()
        ]);
        return apiResponse(500, 'Something went wrong, please try again later');
    }
}




}
