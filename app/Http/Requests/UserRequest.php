<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required' , 'string' , 'min:2'],
            'username'=>['required' , 'unique:users,username'],
            'email'=>['required' , 'unique:users,email'],
            'phone'=>['required' , 'unique:users,phone'],
            'status'=>['in:0,1'],
            'email_verified_at'=>['in:0,1'],
            'country'=>['required', 'string' , 'min:2' , 'max:10'],
            'city'=>['required', 'string' , 'min:2' , 'max:30'],
            'street'=>['required', 'string' , 'min:2' , 'max:30'],
            'password'=>['required' , 'confirmed'],
            'password_confirmation'=>['required'],
            'image'=>['required'],

        ];
    }

    public function messages()
{
    return [
        'name.required'                  => 'Name is required.',
        'name.string'                    => 'Name must be a string.',
        'name.min'                       => 'Name must be at least 2 characters.',
        'username.required'              => 'Username is required.',
        'username.unique'                => 'Username is already taken.',
        'email.required'                 => 'Email is required.',
        'email.unique'                   => 'Email is already taken.',
        'phone.required'                 => 'Phone number is required.',
        'phone.unique'                   => 'Phone number is already taken.',
        'status.in'                       => 'Status must be either 0 or 1.',
        'email_verified_at.in'           => 'Email verified value must be 0 or 1.',
        'country.required'               => 'Country is required.',
        'country.min'                    => 'Country must be at least 2 characters.',
        'country.max'                    => 'Country must not exceed 10 characters.',
        'city.required'                  => 'City is required.',
        'city.min'                       => 'City must be at least 2 characters.',
        'city.max'                       => 'City must not exceed 30 characters.',
        'street.required'                => 'Street is required.',
        'street.min'                     => 'Street must be at least 2 characters.',
        'street.max'                     => 'Street must not exceed 30 characters.',
        'password.required'              => 'Password is required.',
        'password.confirmed'             => 'Password confirmation does not match.',
        'password_confirmation.required' => 'Password confirmation is required.',
        'image.required'                 => 'Profile image is required.',
        'image.image'                    => 'File must be an image.',
        'image.mimes'                    => 'Image must be jpeg, jpg, png, or gif.',
    ];
}
}
