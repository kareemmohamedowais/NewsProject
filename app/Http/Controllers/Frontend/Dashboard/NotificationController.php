<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function index(){
        auth()->user()->unreadNotifications->markAsRead();
        return view('frontend.dashboard.notification');
    }
    public function delete(Request $request){
        $notification = auth()->user()->notifications()
        ->where('id',$request->notify_id)->first();
        if(!$notification){
            Session::flash('error','try agian ');
            return redirect()->back();
        }
            $notification->delete();
            Session::flash('success','notify deleted ');
            return redirect()->back();
    }
    public function deleteAll(){
        auth()->user()->notifications()->delete();
        Session::flash('success','notify deleted all');
        return redirect()->back();
    }
}
