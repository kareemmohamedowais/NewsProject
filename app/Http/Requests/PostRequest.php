<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'=>['required','string','min:3','max:50'],
            'desc'=>['required','min:10'],
            'category_id'=>['required','exists:categories,id'],
            'comment_able'=>'in:on,off,1,0',
            'images'=>'required',
            'images.*'=>'image|mimes:jpeg,jpg,gif,png',
            'status'=>'nullable|in:1,0',
        ];
    }
// to return custom message
    public function messages(){
        return[
            'desc.required' => 'ادخل الوصف ',
        ];

    }
    //to show attribute name زي منا عايز
    public function attributes(){
        return[
            'title' => 'my titte',
        ];
    }
}
