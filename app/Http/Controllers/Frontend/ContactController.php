<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\ContactRequest;

class ContactController extends Controller
{
    public function index(){
        return view('frontend.contact-us');
    }

    public function store(ContactRequest $request){
        $request->validated();

        $request->merge([
            'ip_address'=>$request->ip(),
        ]);

        $contact = Contact::create($request->except(['_token']));
        // send notification to admins
        $admins = Admin::get();
        Notification::send($admins,new NewContactNotify($contact));

        if (!$contact) {
            Session::flash('error','faild');
            return redirect()->back();
        }
            Session::flash('success','msg created successfully');
            return redirect()->back();


        // Contact::create([
        //     'title'=>$request->title
        // ]);
    }
}
