<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Models\Admin;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;

class ForgetPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('dashboard.auth.passwords.email');
    }
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->withErrors([
                'email' => 'try again later!'
            ]);
        }
        $admin->notify(new SendOtpNotify());
        return redirect()->route('admin.password.showOtpForm',['email'=>$admin->email]);
    }
    public function showOtpForm($email){
        return view('dashboard.auth.passwords.confirm',['email'=>$email]);
    }
    public function verifyOtp(Request $request){
        $request->validate([
        'email' => 'required|email',
        'token' => 'required|min:5',
    ], [
        'token.required' => 'الكود مطلوب.',
        'token.min' => 'الكود غير صحيح',
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'من فضلك أدخل بريد إلكتروني صحيح.',
    ]);
    $otp = (new Otp)->validate($request->email, $request->token);

    if($otp->status == false){
        return redirect()->back()->withErrors([
            'token'=>'Code Is Invalid'
        ]);
    }

    return redirect()->route('admin.password.ShowRestForm',['email'=>$request->email]);

    }


//     You can also add this artisan command to app/Console/Kernel.php to automatically clean on scheduled

// <?php

// protected function schedule(Schedule $schedule)
// {
//     $schedule->command('otp:clean')->daily();
// }


}
