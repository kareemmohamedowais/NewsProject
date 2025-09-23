<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\Post;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PostCollection;

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


}
