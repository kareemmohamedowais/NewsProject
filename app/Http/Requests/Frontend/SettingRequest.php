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
    public function rules()
{
    if ($this->isMethod('put') || $this->isMethod('patch')) {
        return [
            'name'      => ['nullable', 'string', 'min:2', 'max:255'],
            'username'  => ['nullable', 'string', 'max:100', 'unique:users,username,' . $this->user()->id],
            'email'     => ['nullable', 'email', 'unique:users,email,' . $this->user()->id],
            'country'   => ['nullable', 'string', 'max:100'],
            'city'      => ['nullable', 'string', 'max:100'],
            'street'    => ['nullable', 'string', 'max:255'],
            'phone'     => ['nullable', 'digits_between:10,15'],
            'image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    return [
        'name'      => ['required', 'string', 'min:2', 'max:255'],
        'username'  => ['required', 'string', 'max:100', 'unique:users,username'],
        'email'     => ['required', 'email', 'unique:users,email'],
        'country'   => ['required', 'string', 'max:100'],
        'city'      => ['required', 'string', 'max:100'],
        'street'    => ['required', 'string', 'max:255'],
        'phone'     => ['required', 'digits_between:10,15'],
        'image'     => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    ];
}
protected function prepareForValidation()
{
    // لو update هنشيل أي فيلد قيمته null عشان ما يبوظش الداتا
    if ($this->isMethod('put') || $this->isMethod('patch')) {
        $this->replace(input: array_filter($this->all(), fn($value) => !is_null($value)));
    }
}

}
