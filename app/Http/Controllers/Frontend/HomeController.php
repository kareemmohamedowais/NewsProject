<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::active()->with('images')->latest()->paginate(9);

        $gretest_posts_views = Post::active()->orderByDesc('num_of_views')->take(3)->get();

        $oldest_news = Post::active()->oldest()->take(3)->get();

        $gretest_posts_comments = Post::active()->withCount('comments')
            ->orderByDesc('comments_count')
            ->take(3)
            ->get();

        $categories = Category::all();
        $categories_with_posts = $categories->map(function ($category) {
            $category->posts = $category->posts()->limit(4)->get();
            return $category;
        });

        return view(
            'frontend.index',
            compact('posts', 'gretest_posts_views', 'categories_with_posts', 'oldest_news', 'gretest_posts_comments')
        );
    }


}
