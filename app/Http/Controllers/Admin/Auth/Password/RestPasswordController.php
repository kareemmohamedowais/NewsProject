<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class RestPasswordController extends Controller
{
    public function ShowRestForm($email){
        return view('dashboard.auth.passwords.reset',compact('email'));
    }

    public function Reset(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|confirmed|min:8',
            'password_confirmation'=>'required'
        ]);
        $admin = Admin::where('email',$request->email)->first();

        if(!$admin){
            return redirect()->back()->with([
            'error'=>'try again later!'
        ]);
        }
        $admin->update([
            'password'=>bcrypt($request->password),
        ]);

        return redirect()->route('admin.login.show')->with([
            'success'=>'your password updated successfully '
        ]);
    }
}
