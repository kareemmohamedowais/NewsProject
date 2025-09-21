<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\GeneralController;
use App\Http\Controllers\Api\Setting\SettingController;
use App\Http\Controllers\Api\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login',[LoginController::class,'login']);
Route::post('auth/register',[RegisterController::class,'register']);
Route::post('auth/logout',[LoginController::class,'logout'])->middleware('auth:sanctum');
Route::post('auth/logout/all',[LoginController::class,'logoutAll'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    // return auth()->user();
});
// iعمل البحث للصفحه الرئيسيه يطبق علي الداتا بتاع الصفحه كلها
// في طريقه تانيه اخليها ترجع علي صفحه لوحده ودي سهله

//********************* Posts Routes ********************************
Route::get('posts/{Keyword?}', [GeneralController::class, 'getPosts']);
Route::get('posts/search/{Keyword}', [GeneralController::class, 'searchGet']);
Route::post('posts/search/', [GeneralController::class, 'searchPost']);
Route::get('posts/show/{slug}', [GeneralController::class, 'showPost']);
Route::get('posts/comments/{slug}', [GeneralController::class, 'showPostComments']);

//********************* Settings Routes ********************************
Route::get('settings', [SettingController::class, 'getSettings']);
// Route::patch('/settings/update', [SettingController::class, 'update']);

//********************* Categories Routes ********************************
Route::get('categories', [CategoryController::class, 'getCategories']);
Route::get('category/{slug}/posts', [CategoryController::class, 'getCategoriesPosts']);

//********************* Contacts Routes ********************************

Route::post('contact/store', [ContactController::class, 'store']);


