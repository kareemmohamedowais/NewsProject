<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    private $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();
    }
    public function resetPassword(ResetPasswordRequest $request){

        $otpcode = $this->otp2->validate($request->email,$request->code);
        if($otpcode->status == false){
            return apiResponse(401 , 'Code Is Invalid');
        }

        $user = User::whereEmail($request->email)->first();
        if(!$user){
        return apiResponse(404 , 'User Not Found');
        }

        $user->update([
        'password'=>Hash::make($request->password),
        ]);
        return  apiResponse(200 , 'Password Updated Successfully');
    }

// resetPassword And Logout All Devices
//     public function resetPasswordAndLogoutAllDevices(ResetPasswordRequest $request)
// {
//     $otpResult = $this->otp2->validate($request->email, $request->code);

//     if (!$otpResult->status) {
//         return apiResponse(401, 'Invalid code');
//     }

//     $user = User::where('email', $request->email)->first();

//     if (!$user) {
//         return apiResponse(404, 'User not found');
//     }

//     // تحديث كلمة السر + عمل logout من كل الأجهزة
//     $user->update([
//         'password' => Hash::make($request->password),
//         'remember_token' => Str::random(60), // تسجيل خروج من كل الأجهزة
//     ]);

//     // لو بتستخدم Laravel Sanctum أو Passport
//     if (method_exists($user, 'tokens')) {
//         $user->tokens()->delete(); // حذف كل التوكينات
//     }

//     return apiResponse(200, 'Password has been reset successfully. Please log in again.');
// }

}
