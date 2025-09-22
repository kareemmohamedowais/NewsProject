<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOtpForgetPassword;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function sendOtp(Request $request){
        $request->validate(['email'=>['required','email','exists:users,email']]);
        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return apiResponse(404,'User Not Found');
        }
        $user->notify(new SendOtpForgetPassword());

        return apiResponse(200 , 'Otp Send , Check Your Email');


    }

//     public function sendOtp(Request $request)
// {
//     $request->validate([
//         'email' => ['required', 'email', 'exists:users,email'],
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if (!$user) {
//         return apiResponse(404, 'User not found');
//     }

//     // مفتاح المحاولات لكل إيميل
//     $cacheKey = 'send_otp_' . $user->id;

//     // لو لسه فيه OTP اتبعت قريب
//     if (cache()->has($cacheKey)) {
//         return apiResponse(429, 'OTP already sent. Please wait before trying again.');
//     }

//     // إرسال الإشعار
//     $user->notify(new SendOtpForgetPassword());

//     // تخزين قفل مؤقت دقيقة واحدة
//     cache()->put($cacheKey, true, now()->addMinute());

//     return apiResponse(200, 'OTP sent, please check your email');
// }


//  اللي بيحصل هنا:

// كل يوزر له مفتاح في الكاش send_otp_userId.

// لو المستخدم حاول يطلب OTP تاني قبل دقيقة → بنرجع 429 Too Many Requests.

// بعد دقيقة، المفتاح بيتشال أوتوماتيك، ويقدر يطلب OTP من جديد.



}
