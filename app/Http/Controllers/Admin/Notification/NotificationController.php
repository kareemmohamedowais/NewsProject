<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:notifications');
    }
    public function index(){
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();
        $notifications = Auth::guard('admin')->user()->notifications()->get();
        return view('dashboard.notifications.index',compact('notifications'));
    }

    public function destroy($id){
        $notify = Auth::guard('admin')->user()->notifications()->where('id',$id)->first();
        if (!$notify) {
            Session::flash('error','try again latter');
            return redirect()->back();
        }
        $notify->delete();
        Session::flash('success','deleted successfully');
        return redirect()->back();
    }
    public function deleteAll()
    {
        auth('admin')->user()->notifications()->delete();
        Session::flash('success' , 'All Notification Deleted');
        return redirect()->back();

    }


}
