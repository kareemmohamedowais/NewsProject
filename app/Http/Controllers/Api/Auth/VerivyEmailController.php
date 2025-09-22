<?php

namespace App\Http\Controllers\Api\Auth;

use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;

class VerivyEmailController extends Controller
{
    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function verifyEmail(Request $request){
        $request->validate(['code'=>'required|size:5']);
        $user =  auth()->user();
        $code = $request->code;
        $otp2 = $this->otp->validate($user->email,$code);
        if($otp2->status == false){
            return apiResponse(400 , 'Code is invalid');
        }
        if ($user->email_verified_at) {
            return apiResponse(200, 'Email already verified');
        }
        $user->forceFill([
        'email_verified_at' => now(),
        ])->save();
        return apiResponse(200 , 'Email Verified successfully');
    }


    public function sendOtpAgain(){
        $user = auth()->user();
        $user->notify(new SendOtpVerifyUserEmail());
        return apiResponse(200 , 'Otp Send Successfully!');
    }

//عدد محاولات محدودة للتحقق من الكود

//     public function verifyEmail(Request $request)
// {
//     $request->validate([
//         'code' => 'required|string|size:5',
//     ]);

//     $user = auth()->user();
//     $code = $request->input('code');

//     // مفتاح المحاولات لكل مستخدم
//     $attemptKey = 'email_verify_attempts_' . $user->id;

//     // عدد المحاولات الحالية
//     $attempts = cache()->get($attemptKey, 0);

//     if ($attempts >= 3) {
//         return apiResponse(429, 'Too many attempts, please try again later');
//     }

//     // التحقق من الكود
//     $otpResult = $this->otp->validate($user->email, $code);

//     if (!$otpResult->status) {
//         cache()->increment($attemptKey);         // زيادة عدد المحاولات
//         cache()->put($attemptKey, $attempts + 1, now()->addMinutes(10)); // إعادة الضبط بعد 10 دقائق
//         return apiResponse(400, 'Invalid code');
//     }

//     // مسح المحاولات لو الكود صحيح
//     cache()->forget($attemptKey);

//     if ($user->email_verified_at) {
//         return apiResponse(200, 'Email already verified');
//     }

//     $user->forceFill([
//         'email_verified_at' => now(),
//     ])->save();

//     return apiResponse(200, 'Email verified successfully');
// }

}
