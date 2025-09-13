<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Utils\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Frontend\SettingRequest;

class SettingController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('frontend.dashboard.setting',compact('user'));
    }

    public function update(SettingRequest $request){
        $request->validated();
        $user = auth()->user();
        $user->update($request->except(['_token','image']));
        if ($request->hasFile('image')) {
            ImageManager::uploadImages($request,null,$user);

        }

        return redirect()->back()->with('success','updated done');
    }

    public function changePassword(Request $request)
{
    //  Validation
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|string|min:8|confirmed',
        // لازم يكون معاك حقل: new_password_confirmation
    ]);

    $user = Auth::user();
    if (!Hash::check($request->current_password, $user->password)) {
        Session::flash('error','password dose not match');
        return redirect()->back();
    }
    
    $user->update([
        'password'=>Hash::make($request->password)
    ]);
    Session::flash('success','password updated');
    return redirect()->back();


    }
}
