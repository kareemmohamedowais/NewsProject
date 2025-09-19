<?php

namespace App\Http\Controllers\Api\Contact;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewContactNotify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\ContactRequest;

class ContactController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'  => ['required','string','min:2','max:50'],
        'email' => ['required','email'],
        'title' => ['required','string','max:60'],
        'phone' => ['required','string','size:11'],
        'body'  => ['required','string','min:10','max:500'],
    ],[
        'name.required'  => 'الاسم مطلوب',
        'name.min'       => 'الاسم يجب ألا يقل عن 2 حروف',
        'name.max'       => 'الاسم يجب ألا يزيد عن 50 حرف',

        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email'    => 'البريد الإلكتروني غير صحيح',

        'title.required' => 'العنوان مطلوب',
        'title.max'      => 'العنوان يجب ألا يزيد عن 60 حرف',

        'phone.required' => 'رقم الهاتف مطلوب',
        'phone.size'     => 'رقم الهاتف يجب أن يكون 11 رقم بالضبط',

        'body.required'  => 'الرسالة مطلوبة',
        'body.min'       => 'الرسالة يجب ألا تقل عن 10 حروف',
        'body.max'       => 'الرسالة يجب ألا تزيد عن 500 حرف',
    ]);

    if ($validator->fails()) {
        return apiResponse(422, 'Validation Errors', $validator->errors());
    }

    $data = $validator->validated();
    $data['ip_address'] = $request->ip();

    $contact = Contact::create($data);

    if(!$contact){
        return apiResponse(400 , 'Try Again Later!');
    }

    return apiResponse(201 , 'Contact Created Successfully');
}

// public function store(Request $request)
// {
//     $data = $request->validate([
//         'name'  => ['required','string','min:2','max:50'],
//         'email' => ['required','email'],
//         'title' => ['required','string','max:60'],
//         'phone' => ['required','string','size:11'],
//         'body'  => ['required','string','min:10','max:500'],
//     ]);

//     $data['ip_address'] = $request->ip();

//     $contact = Contact::create($data);

//     if(!$contact){
//         return apiResponse(400 , 'Try Again Later!');
//     }

//     return apiResponse(201 , 'Contact Created Successfully');
// }
}
