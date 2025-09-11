<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct(){
        $this->middleware(['guest:admin'])->only(['showLoginForm','checkAuth']);
        $this->middleware(['auth:admin'])->only(['logout']);
    }
    public function showLoginForm(){
        return view('dashboard.auth.login');
    }

public function checkAuth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'remember'=>'in:on,off',
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            // if admin has permession home -> redirect to home , else redire the first page in his permessions
            // $permissions = Auth::guard('admin')->user()->authorization->permissions;
            // $first_permession = $permissions[0];
            // return $permissions;

            // if (!in_array('home', $permissions)) {
                // return redirect()->intended('admin/' . $first_permession);
            // }
            return redirect()->intended(route('admin.index'));
        }
        return redirect()->back()->withErrors(['email' => 'credentials dose not match!']);

    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.show'); // رجّع لصفحة تسجيل الدخول
    }

}
