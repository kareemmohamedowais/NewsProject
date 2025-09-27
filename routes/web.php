<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\NewsSubscriberController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\Dashboard\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::redirect('/', '/home');


Route::group([
    'as' => 'frontend.'
], function () {
    Route::fallback(function(){
        return response()->view('errors.404');
    });
    Route::get('/home', [HomeController::class, 'index'])->name('index');
    Route::post('news-subscibe',[NewsSubscriberController::class,'store'])->name('news.subscribe');
    Route::get('category/{slug}',CategoryController::class)->name('category.posts');
    // Post controller routes
    Route::controller(PostController::class)->name('post.')->prefix('post')->group(function(){
    Route::get('/{slug}','show')->name('show');
    Route::get('/comments/{slug}','GetAllComments')->name('getComments');
    Route::post('/comments/store','StoreComment')->name('comments.store');

    });

    //contact controller routes
    Route::controller(ContactController::class)->name('contact.')->prefix('contact')->group(function(){
    Route::get('','index')->name('index');
    Route::post('/store','store')->name('store');
    });

    Route::match(['post','get'],'search',SearchController::class)->name('search');

    // dashboard controller routes (profile page)
    Route::prefix('Acount')->name('dashboard.')->middleware(['auth','verified','check-user-status'])
    ->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/profile','index')->name('profile');
            Route::post('/post/store','store')->name('post.store');
            Route::delete('/post/delete','delete')->name('post.delete');
            Route::get('/post/comments/{id}','getComments')->name('post.getComments');

            //edit post routes
            Route::get('/post/{slug}/edit', 'edit')->name('post.edit');
            Route::put('/post/update', 'update')->name('post.update');
            Route::post('/post/image/{id}/delete', 'deletePostImage')->name('post.image.delete');


        });
        //setting routes
        Route::prefix('setting')->controller(SettingController::class)->group(function(){
            Route::get('','index')->name('setting');
            Route::patch('','update')->name('setting.update');
            Route::post('/changePassword','changePassword')->name('setting.changePassword');
        });
        //notivications route
        Route::prefix('notification')->controller(NotificationController::class)->group(function(){
            Route::get('/','index')->name('notification.index');
            Route::post('/delete','delete')->name('notification.delete');
            Route::get('/deleteAll','deleteAll')->name('notification.deleteAll');
        });
    });

    Route::get('wait' , function(){
        return view('frontend.wait');
    })->name('wait');

});

Route::get('auth/{provider}/redirect' , [SocialLoginController::class , 'redirect'])
    ->name('auth.socilate.redirect');
Route::get('auth/{provider}/callback' , [SocialLoginController::class , 'callback'])
    ->name('auth.socilate.callback');




Auth::routes();

Route::get('email/verify', [VerificationController::class,'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class,'resend'])->name('verification.resend');

