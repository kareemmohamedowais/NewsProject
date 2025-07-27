<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Category;
use App\Models\RelatedNewsSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Cache::forget('latest_posts');

        if (!Cache::has('latest_posts')) {
            $latest_posts = Post::select('id','title','slug')->latest()->limit(5)->get();
            Cache::remember('latest_posts',3600,function() use($latest_posts){
            return $latest_posts;
        });

        if (! Cache::has('gretest_posts_comments')) {

        $gretest_posts_comments = Post::withCount('comments')
            ->orderByDesc('comments_count')
            ->take(5)
            ->get();
        Cache::remember('gretest_posts_comments',3600,function()use($gretest_posts_comments){
            return $gretest_posts_comments;
        });
        }
        $gretest_posts_comments = Cache::get('gretest_posts_comments');

        $latest_posts = Cache::get('latest_posts');

        //share related sites
        $related_sites = RelatedNewsSite::select('name','url')->get();
        //share categories
        $categories = Category::select('id','slug','name')->get();
        view()->share([
            'related_sites'=>$related_sites,
            'categories'=>$categories,
            'latest_posts'=>$latest_posts,
            'gretest_posts_comments'=>$gretest_posts_comments,
        ]);



    }
}
}
