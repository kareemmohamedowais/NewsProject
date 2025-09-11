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
            'small_desc'=>['required','string','min:3','max:250'],
            'desc'=>['required','min:10'],
            'category_id'=>['required','exists:categories,id'],
            'comment_able'=>'in:on,off,1,0',
            'images'=>'required',
            'images.*'=>'image|mimes:jpeg,jpg,gif,png',
            'status'=>'nullable|in:1,0',
        ];
    }
// to return custom message
    public function messages()
{
    return [
        'title.required'       => 'The title field is required.',
        'title.string'         => 'The title must be a valid string.',
        'title.min'            => 'The title must be at least 3 characters.',
        'title.max'            => 'The title may not be greater than 50 characters.',

        'small_desc.required'  => 'The short description is required.',
        'small_desc.string'    => 'The short description must be a valid string.',
        'small_desc.min'       => 'The short description must be at least 3 characters.',
        'small_desc.max'       => 'The short description may not be greater than 250 characters.',

        'desc.required'        => 'The description is required.',
        'desc.min'             => 'The description must be at least 10 characters.',

        'category_id.required' => 'Please select a category.',
        'category_id.exists'   => 'The selected category is invalid.',

        'comment_able.in'      => 'Invalid option for comments.',

        'images.required'      => 'Please upload at least one image.',
        'images.*.image'       => 'Each file must be an image.',
        'images.*.mimes'       => 'Images must be of type: jpeg, jpg, gif, or png.',

        'status.in'            => 'Invalid status value.',
    ];
}

    //to show attribute name زي منا عايز
    public function attributes(){
        return[
            'title' => 'my titte',
        ];
    }
}
