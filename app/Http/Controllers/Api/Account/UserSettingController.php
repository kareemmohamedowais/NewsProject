<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Frontend\SettingRequest;

class UserSettingController extends Controller
{
    public function updateSetting(SettingRequest $request){
        $user = auth('sanctum')->user();
        if(!$user){
            return apiResponse(404 , 'Opps Something was wrong!');
        }
    // خُد البيانات المتحققة بس من SettingRequest
    // $data = $request->validated();

    // // شيل الحقول اللي مش محتاج تحدثها
    // unset($data['_method'], $data['image']);

    // // حدث بيانات المستخدم
    // $user->update($data);

        $user->update($request->except(['_method','image']));
        if ($request->hasFile('image')) {
        ImageManager::uploadImages($request , null, $user);
        }
        return apiResponse(200 , 'Profile Data Updated Successfully');

        // return apiResponse(200, 'Profile data updated successfully', [
        //         'user' => UserResource::make($user->fresh()) // رجع أحدث نسخة من البيانات
        //     ]);
        }
    public function updatePassword(Request $request){
        $request->validate($this->filterPasswordRequest());

        $user = auth('sanctum')->user();
        if(!$user){
            return apiResponse(404 , 'Opps Something was wrong!');
        }
        if(!Hash::check($request->current_password , $user->password)){
            return apiResponse(400, 'Password dose not match');
        }

        $user->update([
        'password' => Hash::make($request->password),
        ]);

        // logout for all devieces after update password
        // $user->tokens()->delete();

        // امسح كل التوكنات ما عدا الحالي
        $user->tokens()
        ->where('id', '!=', $request->user()->currentAccessToken()->id)
        ->delete();



        return apiResponse(200, 'Password  Update Successfully');
    }

    private function  filterPasswordRequest():array
    {
        return [
        'current_password'      => ['required', 'string', 'max:20'],
        'password'              => ['required', 'string', 'confirmed', 'min:8', 'max:20'],
        'password_confirmation' => ['required', 'string', 'max:20'],
    ];
    }
}
