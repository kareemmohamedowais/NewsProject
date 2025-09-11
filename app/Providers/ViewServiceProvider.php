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



        //share related sites
        $related_sites = RelatedNewsSite::select('name','url')->get();
        //share categories
        $categories = Category::active()->select('id','slug','name')->get();
        view()->share([
            'related_sites'=>$related_sites,
            'categories'=>$categories,
        ]);



    }
}

