<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;

class RegisterController extends Controller
{
    public function register(UserRequest $request){
        DB::beginTransaction();
        try {
        $user = User::create([
            'name'=>$request->post('name'),
            'username'=>$request->post('username'),
            'email'=>$request->post('email'),
            'phone'=>$request->post('phone'),
            'country'=>$request->post('country'),
            'city'=>$request->post('city'),
            'street'=>$request->post('street'),
            'password'=>$request->post('password'),
        ]);
        if(!$user){
                return apiResponse(400 , 'Try Again Latter!');
            }
        if($request->hasFile('image')){
            ImageManager::uploadImages($request , null , $user);
        }
        $token = $user->createToken('user-token')->plainTextToken;

        $user->notify(new SendOtpVerifyUserEmail());


        DB::commit();
        return apiResponse(201 , 'User Created Successfully ' , ['token'=>$token]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error From Registration proccess : ' . $e->getMessage());
            return apiResponse(500 , 'Enternal server error');
        }


    }
}
