<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewContactNotify;
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

        if (!$contact) {
            Session::flash('error','faild');
            return redirect()->back();
        }

        $userImage = Auth::guard('web')->user()->image;
        // send notification to admins
        $admins = Admin::get();
        Notification::send($admins,new NewContactNotify($contact,$userImage));

        Session::flash('success','msg created successfully');
        return redirect()->back();


        // Contact::create([
        //     'title'=>$request->title
        // ]);
    }
}
