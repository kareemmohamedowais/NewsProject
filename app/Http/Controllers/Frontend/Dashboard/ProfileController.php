<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Models\Post;
use App\Models\Image;
use App\Utils\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    //

    public function index(){
        return view('frontend.dashboard.profile');
    }
    public function store(PostRequest $request){

        // return $request;
        try {
        DB::beginTransaction();

        $request->validated();
        // to change input value from  on & off  to  0 , 1
        $request->comment_able == "on" ? $request->merge(['comment_able'=>1]):$request->merge(['comment_able'=>0]);
        // to add user_id into request
        $request->merge(['user_id'=>auth()->user()->id]);
        // store post
        $post = Post::create($request->except(['_token','images']));
        // another way to store
        // $post = Post::create([
        //     'title'=>$request->title,
        //     'desc'=>$request->desc,
        //     'category_id'=>$request->category_id,
        //     'comment_able'=>$request->comment_able,
        //     'user_id'=>auth()->user()->id,
        // ]);


        ImageManager::uploadImages($request,$post);

        DB::commit();
        Cache::forget('read_more_posts');
        Cache::forget('latest_posts');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['errors',$e->getMessage()]);
    }

    Session::flash('success','post create done');
    return redirect()->back();

    }
}
