<?php

use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\Password\RestPasswordController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Admin\Category\CategoryController;

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
    // Users Management
    Route::resource('users',UserController::class);
    Route::get('users/block/{id}',[UserController::class,'changeStatus'])->name('users.changeStatus');
    // Category Management
    Route::resource('categories',CategoryController::class);
    Route::get('category/block/{id}',[CategoryController::class,'changeStatus'])->name('category.changeStatus');

    Route::get('dashboard',function(){
        return view('dashboard.index');
    })->name('index');

});

