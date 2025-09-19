<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
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
            'name'  => ['required','string','min:2','max:50'],
            'email' => ['required','email'],
            'title' => ['required','string','max:60'],
            'phone' => ['required','string','min:11','max:11'],
            'body'  => ['required','string','min:10','max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Name is required.',
            'name.min'       => 'Name must be at least 2 characters.',
            'name.max'       => 'Name must not exceed 50 characters.',

            'email.required' => 'Email is required.',
            'email.email'    => 'Please provide a valid email address.',

            'title.required' => 'Title is required.',
            'title.max'      => 'Title must not exceed 60 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.min'      => 'Phone number must be exactly 11 digits.',
            'phone.max'      => 'Phone number must be exactly 11 digits.',

            'body.required'  => 'Message body is required.',
            'body.min'       => 'Message must be at least 10 characters.',
            'body.max'       => 'Message must not exceed 500 characters.',
        ];
    }



// protected function failedValidation(Validator $validator): void
// {
//     throw new HttpResponseException(
//         apiResponse(422, 'Validation Error', $validator->errors())
//     );
// }




}
