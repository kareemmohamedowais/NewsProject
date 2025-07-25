<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
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
        // can use firstorcreate
        $getSetting = Setting::firstOr(function(){
            return Setting::create([
                'site_name'=>'news',
                'logo'=>'/test/logo.png',
                'favicon'=>'default',
                'email'=>'news@gmail.com',
                'facebook'=>'https://www.facebook.com/',
                'twitter'=>'https://www.twitter.com/',
                'insagram'=>'https://www.instagram.com/',
                'youtupe'=>'https://www.youtupe.com/',
                'country'=>'Egypt',
                'city'=>'beni suif',
                'street'=>'elmror',
                'phone'=>'01113604940',
                'small_desc'=>'23 of PARAGE is equality of condition, blood, or dignity; specifically : equality between persons (as brothers) one of whom holds a part of a fee ',
            ]);
        });

        $getSetting->whatsapp = "https://wa.me/".$getSetting->phone;

        //share related sites
        $related_sites = RelatedNewsSite::select('name','url')->get();
        //share categories
        $categories = Category::select('slug','name')->get();
        view()->share([
            'getSetting'=>$getSetting,
            'related_sites'=>$related_sites,
            'categories'=>$categories,
        ]);




    }
}
