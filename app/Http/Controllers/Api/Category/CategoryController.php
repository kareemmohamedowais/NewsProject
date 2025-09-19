<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function getCategories(){
        $categories = Category::active()->get();
        if(!$categories){
            return apiResponse(404,'categories not found');
        }
        return apiResponse(200,'categories ',new CategoryCollection($categories));
    }
    public function getCategoriesPosts($slug){
        $category = Category::active()->where('slug',$slug)->first();
        if(!$category){
            return apiResponse(404,'category not found');
        }
        $posts = $category->posts;
        return apiResponse(200,'this is category posts ',new PostCollection($posts));
    }
}
