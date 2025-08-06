<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\NewsSubscriberController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;

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


Route::group([
    'as' => 'frontend.'
], function () {
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

    // dashboard controller routes
    Route::prefix('Acount')->name('dashboard.')->middleware('auth','verified')
    ->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/profile','index')->name('profile');
            Route::post('/post/store','store')->name('post.store');
        });
    });
});


Auth::routes();

Route::get('email/verify', [VerificationController::class,'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class,'resend'])->name('verification.resend');
