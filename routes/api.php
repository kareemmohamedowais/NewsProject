<?php

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use Predis\Configuration\Option\Prefix;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Account\PostController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\General\GeneralController;
use App\Http\Controllers\Api\Setting\SettingController;
use App\Http\Controllers\Api\Auth\VerivyEmailController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Account\UserSettingController;
use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\RelatedNews\RelatedNewsController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\Password\ForgetPasswordController;

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
//********************* Auth Register Routes ********************************
Route::post('auth/register',[RegisterController::class,'register']);
//********************* Auth Login  & Logout  Routes ********************************
Route::controller(LoginController::class)->group(function(){
    Route::post('auth/login','login');
    Route::post('auth/logout','logout')->middleware('auth:sanctum');
    Route::post('auth/logout/all','logoutAll')->middleware('auth:sanctum');
});
//********************* Auth VerivyEmail Routes ********************************
Route::controller(VerivyEmailController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('auth/email/verify','verifyEmail');
    Route::get('auth/email/send-again','sendOtpAgain');
});
//********************* Auth ForgetPassword Routes ********************************
Route::controller(ForgetPasswordController::class)->group(function(){
    Route::post('password/email','sendOtp');
});

//********************* Auth ResetPassword Routes ********************************
Route::controller(ResetPasswordController::class)->group(function(){
    Route::post('password/reset','resetPassword');
});


Route::middleware(['auth:sanctum','check-user-status'])->prefix('account')->group(function(){
    // Get Auth User Route
Route::get('/user', function (Request $request) {
    return UserResource::make(auth()->user());
    // return auth()->user();
});

//******************************   User Settings Routes   ****************************************//
    Route::put('user/setting',[UserSettingController::class,'updateSetting']);
    Route::put('user/password',[UserSettingController::class,'updatePassword']);

//******************************   User Posts Routes   ****************************************//

Route::controller(PostController::class)->prefix('posts')->group(function(){
    Route::get('/',                      'getPosts');
    Route::post('/store',                'storeUserPost');
    Route::post('/update/{post_id}',     'updateUserPost');
    Route::delete('/destroy/{post_id}',  'destroyUserPost');

    Route::get('/comments/{post_id}',    'getPostComments');
    Route::post('/comments/store' ,       'StoreComment');
});
//******************************   Notifications Routes   ****************************************//
    // Get all notifications + unread
    Route::get('notifications' , [NotificationController::class , 'getNotifications']);
    // Mark single notification as read
    Route::get('notifications/read/{id}' , [NotificationController::class , 'readNotifications']);
    // Mark all notifications as read
    Route::get('notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    // Delete single notification
    Route::delete('notifications/{id}', [NotificationController::class, 'deleteNotification']);
    // Delete all notifications
    Route::delete('notifications', [NotificationController::class, 'deleteAllNotifications']);

});



// iعمل البحث للصفحه الرئيسيه يطبق علي الداتا بتاع الصفحه كلها
// في طريقه تانيه اخليها ترجع علي صفحه لوحده ودي سهله

//********************* Posts Routes ********************************
Route::controller(GeneralController::class)->prefix('posts')->group(function(){
    Route::get('/{Keyword?}',  'getPosts');
    Route::get('/search/{Keyword}',  'searchGet');
    Route::post('/search',  'searchPost');
    Route::get('/show/{slug}',  'showPost')->name('api.post.show');
    Route::get('/comments/{slug}',  'showPostComments');
});


//********************* Settings Routes ********************************
Route::get('settings', [SettingController::class, 'getSettings']);
// Route::patch('/settings/update', [SettingController::class, 'update']);

//********************* Categories Routes ********************************
Route::get('categories', [CategoryController::class, 'getCategories']);
Route::get('category/{slug}/posts', [CategoryController::class, 'getCategoriesPosts']);

//********************* Contacts Routes ********************************

Route::post('contact/store', [ContactController::class, 'store']);
//********************* RelatedNews Routes ********************************

Route::get('related-sites', [RelatedNewsController::class, 'RelatedSites']);


