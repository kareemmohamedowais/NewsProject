<?php

use App\Http\Controllers\Api\Category\CategoryController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\GeneralController;
use App\Http\Controllers\Api\Setting\SettingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', [GeneralController::class, 'getPosts']);

Route::get('posts/show/{slug}', [GeneralController::class, 'showPost']);
Route::get('posts/comments/{slug}', [GeneralController::class, 'showPostComments']);

Route::get('settings', [SettingController::class, 'getSettings']);
// Route::patch('/settings/update', [SettingController::class, 'update']);

Route::get('categories', [CategoryController::class, 'getCategories']);
Route::get('category/{slug}/posts', [CategoryController::class, 'getCategoriesPosts']);
