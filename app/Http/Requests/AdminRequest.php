<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $admin_id = $this->route('admin');
        $rules = [
            'name'=>['required' , 'min:2' , 'max:60'],
            'username'=>['required' , 'min:6' , 'max:100' , 'unique:admins,username,'.$admin_id],
            'email'=>['required' , 'email' , 'unique:admins,email,'.$admin_id],
            'status'=>['required' , 'in:0,1'],
            'role_id'=>['required', 'exists:authorizations,id'],
        ];

        if(in_array($this->method() , ['PUT' , 'PATCH'])){
            $rules['password']              =['nullable' , 'confirmed' , 'min:8' , 'max:100'];
            $rules['password_confirmation'] =['nullable'];
        }else{
            $rules['password']=['required' , 'confirmed' , 'min:8' , 'max:100'];
            $rules['password_confirmation']=['required'];
        }
        return $rules;
    }
    public function messages(): array
{
    return [
        'name.required' => 'Name is required.',
        'name.min' => 'Name must be at least :min characters.',
        'name.max' => 'Name must not exceed :max characters.',

        'username.required' => 'Username is required.',
        'username.min' => 'Username must be at least :min characters.',
        'username.max' => 'Username must not exceed :max characters.',
        'username.unique' => 'This username is already taken.',

        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
        'email.max' => 'Email must not exceed :max characters.',

        'status.required' => 'User status is required.',
        'status.in' => 'The selected status is invalid.',

        'role_id.required' => 'Please select a role.',
        'role_id.exists' => 'The selected role does not exist.',

        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least :min characters.',
        'password.max' => 'Password must not exceed :max characters.',
        'password.confirmed' => 'Password and confirmation do not match.',

        'password_confirmation.required' => 'Password confirmation is required.',
    ];
}

}
