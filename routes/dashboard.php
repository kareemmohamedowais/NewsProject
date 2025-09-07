<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Home\HomeController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Auth\Password\RestPasswordController;
use App\Http\Controllers\Admin\Authorization\AuthorizationController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;

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

// auth routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login.show');
        Route::post('login/check', 'checkAuth')->name('login.check');
        Route::post('logout', 'logout')->name('logout');
    });
    Route::group(['prefix'=>'password','as'=>'password.'],function(){
        Route::controller(ForgetPasswordController::class)->group(function(){
            Route::get('email','showEmailForm')->name('email');
            Route::post('email','sendOTP')->name('sendotp');
            Route::get('verify/{email}','showOtpForm')->name('showOtpForm');
            Route::post('verify','verifyOtp')->name('verifyOtp');
        });
        Route::get('reset/{email}',[RestPasswordController::class,'ShowRestForm'])->name('ShowRestForm');
        Route::post('reset',[RestPasswordController::class,'Reset'])->name('Reset');

    });
});



Route::group(['prefix'=>'admin','as'=>'admin.','middleware'=>'auth:admin'],function(){
    // Home
    Route::get('dashboard',[HomeController::class,'index'])->name('index');

    // authorizations Management
    Route::resource('authorizations',AuthorizationController::class);


    // Users Management
    Route::resource('users',UserController::class);
    Route::get('users/block/{id}',[UserController::class,'changeStatus'])->name('users.changeStatus');
    // Category Management
    Route::resource('categories',CategoryController::class);
    Route::get('category/block/{id}',[CategoryController::class,'changeStatus'])->name('category.changeStatus');
    // Posts Management
    Route::resource('posts',PostController::class);
    Route::get('post/block/{id}',[PostController::class,'changeStatus'])->name('posts.changeStatus');
    Route::post('/posts/image/{id}/delete', [PostController::class,'deletePostImage'])->name('posts.image.delete');
    Route::get('posts/comment/delete/{id}' ,      [PostController::class , 'deleteComment'])->name('posts.deleteComment');
    // Admins Management
    Route::resource('admins',AdminController::class);
    Route::get('admins/status/{id}',[AdminController::class,'changeStatus'])->name('admins.changeStatus');
    // Profile Management
    Route::controller( ProfileController::class)->prefix('profile')
    ->as('profile.')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('/update','update')->name('update');
    });
    // Settings Management
    Route::controller( SettingController::class)->prefix('setting')
    ->as('settings.')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('/update','update')->name('update');
    });
    // Contact Management
    Route::controller( ContactController::class)->prefix('contact')
    ->as('contacts.')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/show/{id}','show')->name('show');
        Route::delete('/destroy/{id}','destroy')->name('destroy');
    });


});

