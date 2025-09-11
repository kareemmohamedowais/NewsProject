<?php

namespace App\Http\Requests;

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
        'site_name'   => ['required', 'string', 'min:2', 'max:60'],
        'email'       => ['required', 'email'],
        'phone'       => ['required', 'numeric'],
        'country'     => ['required', 'string', 'max:30'],
        'city'        => ['required', 'string', 'max:30'],
        'street'      => ['required', 'string', 'max:70'],
        'facebook'    => ['required', 'string'],
        'twitter'     => ['required', 'string'],
        'insagram'    => ['required', 'string'],
        'youtupe'     => ['required', 'string'],
        'small_desc'  => ['required', 'string', 'min:10'],
        'logo'        => ['nullable', 'image'],
        'favicon'     => ['nullable', 'image'],
    ];
}

public function messages(): array
{
    return [
        'site_name.required'  => 'The site name is required.',
        'site_name.min'       => 'The site name must be at least 2 characters.',
        'site_name.max'       => 'The site name must not exceed 60 characters.',

        'email.required'      => 'The email is required.',
        'email.email'         => 'Please enter a valid email address.',

        'phone.required'      => 'The phone number is required.',
        'phone.numeric'       => 'The phone number must be numeric.',

        'country.required'    => 'The country is required.',
        'country.max'         => 'The country must not exceed 30 characters.',

        'city.required'       => 'The city is required.',
        'city.max'            => 'The city must not exceed 30 characters.',

        'street.required'     => 'The street is required.',
        'street.max'          => 'The street must not exceed 70 characters.',

        'facebook.required'   => 'The Facebook link is required.',
        'twitter.required'    => 'The Twitter link is required.',
        'insagram.required'   => 'The Instagram link is required.',
        'youtupe.required'    => 'The YouTube link is required.',

        'small_desc.required' => 'The small description is required.',
        'small_desc.min'      => 'The small description must be at least 10 characters.',

        'logo.image'          => 'The logo must be a valid image file.',
        'favicon.image'       => 'The favicon must be a valid image file.',
    ];
}
}
