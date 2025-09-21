<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=>['required','email','max:50'],
            'password'=>['required','max:50']
        ]);

        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return apiResponse(401,'credintials doesnt match');
        }
        if ($user && Hash::check($request->password ,$user->password)) {
        $token = $user->createToken('user-token',[],now()->addMinutes(60))->plainTextToken;
        // $token = $user->createToken('user_token')->plainTextToken;
        return apiResponse(200 , 'User Loged Successfully' , ['token'=>$token]);
        }
        return apiResponse(401 , 'Credensials dose not match p');
    }
    public function logout(){
        $user = auth('sanctum')->user();
        // $user = request()->user();
        $user->currentAccessToken()->delete();
        return apiResponse(200 , 'Token Deleted Successfully!');

    }
    public function logoutAll(){
        // $user = auth('sanctum')->user();
        $user = request()->user();
        // Revoke all tokens...
        $user->tokens()->delete();
        return apiResponse(200 , 'Logout All Successfully!');

    }
}
