<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        $category = Category::active()->whereSlug($slug)->firstOrFail();

        $posts = $category->posts()
            ->with('images')
            ->active()
            ->paginate(9);
            // return $posts;
        return view('frontend.category-posts', compact('posts', 'category'));
        }



}
