<?php

namespace App\Http\Controllers\Api\General;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\CommentCollection;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryCollection;

class GeneralController extends Controller
{
    public function getPosts(){

        $query = Post::query()
        ->with(['user', 'category', 'admin', 'images'])
        ->activeUser()
        ->activeCategory()
        ->active();

        if(request()->query('keyword')){
            $query->where('title' ,'LIKE', '%' . request()->query('keyword') . '%');
        }

        $posts                  = clone $query->latest()->paginate(4);
        $category_with_posts    = $this->categoryWithPosts();
        $oldest_posts           = $this->oldestPosts(clone $query);
        $most_read_posts        = $this->mostReadPosts(clone $query);
        $latest_posts           = $this->latestPosts(clone $query);
        $popular_posts          = $this->popularPosts(clone $query);

        // PostResource::make($post);         if we have one post
        // new PostResource($post);           if we have one post
        // PostResource::collection($posts);  if we have most of one post
        // new PostCollection($posts)         if we have most of one post // عشان هو كد كده اكثر من عنصر مع ميزه اضافه بيانات اضافيه للكوليكشن ككل

        $data = [
            'all_posts'              =>(new PostCollection($posts))->response()->getData(true),
            'category_with_posts'    =>new CategoryCollection($category_with_posts),
            'oldest_posts'           =>new PostCollection($oldest_posts),
            'most_read_posts'        =>new PostCollection($most_read_posts),
            'latest_posts'           =>new PostCollection($latest_posts),
            'popular_posts'          =>new PostCollection($popular_posts),
        ];
        return apiResponse(200, 'Success', $data);

    }

    public function latestPosts($query){
        $latest_posts = $query->latest()->take(3)->get();
        if (!$latest_posts) {
            return apiResponse(404, 'Posts Not Found');
        }
        return $latest_posts;
    }
    public function mostReadPosts($query){
        $most_read_posts = $query->orderBy('num_of_views','desc')->take(3)->get();
        if (!$most_read_posts) {
            return apiResponse(404, 'Posts Not Found');
        }
        return $most_read_posts;
    }
    public function oldestPosts($query){
        $oldest_posts = $query->oldest()->limit(3)->get();
        if (!$oldest_posts) {
            return apiResponse(404, 'Posts Not Found');
        }
        return $oldest_posts;
    }
    public function categoryWithPosts(){
        $categories = Category::active()->get();
        if (!$categories) {
            return apiResponse(404, 'categories Not Found');
        }
        $category_with_posts = $categories->map(function($category){
            $category->posts =  $category->posts()->active()->limit(4)->get();
            return $category;
        });
        if (!$category_with_posts) {
            return apiResponse(404, 'category_with_posts Not Found');
        }
        return $category_with_posts;
    }
    public function popularPosts($query){
        $popular_posts = $query->active()->withCount('comments')
            ->orderByDesc('comments_count')
            ->take(3)
            ->get();
        if (!$popular_posts) {
            return apiResponse(404, 'Posts Not Found');
        }
        return $popular_posts;
    }

    public function showPost($slug) {
        $post = Post::with(['user','admin','category','images','comments'])
        ->active()
        ->activeUser()
        ->activeCategory()
        ->where('slug',$slug)
        ->first();

        if(!$post){
            return apiResponse(404, 'Post Not Found');
        }
        return apiResponse(200, 'this is post', PostResource::make($post));

    }

    public function showPostComments($slug){
        $post = Post::active()
            ->activeUser()
            ->activeCategory()
            ->whereSlug($slug)
            ->first();

        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }

        $comments = $post->comments;
        if (!$comments) {
            return apiResponse(404, 'Comments Not Found');
        }

        return apiResponse(200, 'This Post Commetns', new CommentCollection($comments));

    }


public function searchGet($keyword)
{
    // validate route param
    $validator = Validator::make(
        ['keyword' => $keyword],
        ['keyword' => ['required', 'string', 'min:2', 'max:100']]
    );

    if ($validator->fails()) {
        return apiResponse(422, 'Validation Error', $validator->errors());
    }

    $posts = Post::with(['user', 'category', 'admin', 'images'])
        ->where('title', 'LIKE', "%{$keyword}%")
        ->orWhere('desc', 'LIKE', "%{$keyword}%")
        ->paginate(5);

    if ($posts->isEmpty()) {
        return apiResponse(404, 'Posts Not Found');
    }

    return apiResponse(200, 'Search Results', (new PostCollection($posts))->response()->getData(true));
}


public function searchPost(Request $request)
{
    $validator = Validator::make($request->all(), [
        'keyword' => ['required', 'string', 'min:2', 'max:100'],
    ]);

    if ($validator->fails()) {
        return apiResponse(422, 'Validation Error', $validator->errors());
    }

    $keyword = $validator->validated()['keyword'];

    $posts = Post::with(['user', 'category', 'admin', 'images'])
        ->where('title', 'LIKE', "%{$keyword}%")
        ->orWhere('desc', 'LIKE', "%{$keyword}%")
        ->paginate(5);

    if ($posts->isEmpty()) {
        return apiResponse(404, 'Posts Not Found');
    }

    return apiResponse(200, 'Search Results', (new PostCollection($posts))->response()->getData(true));
}


}
