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
        'email' => $credentials['email'],
        'password' => $credentials['password'],
        ],
        $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.index'));
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.show'); // رجّع لصفحة تسجيل الدخول
    }

}
