<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . auth()->user()->id,
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
