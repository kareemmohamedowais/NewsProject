<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Image;
use App\Utils\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    //

    public function index(){
        $posts = Post::active()
        ->with('images')
        ->where('user_id',auth()->user()->id)
        ->latest()
        ->get();
        // طريقه اخري
        // $posts = auth()->user()->posts()->active()->with('images')->get();
        return view('frontend.dashboard.profile',compact('posts'));
    }
    public function store(PostRequest $request){

        // return $request;
        try {
        DB::beginTransaction();

        $request->validated();
        // to change input value from  on & off  to  0 , 1
        // $this->commentAble($request);
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
        Session::flash('success','post create done');
        return redirect()->back();

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['errors',$e->getMessage()]);
    }



    }

    public function edit($slug){

        $post = Post::with('images')->whereSlug($slug)->first();
        if(!$post){
            abort(404);
        }
        return view('frontend.dashboard.edit-post',compact("post"));
    }
    public function update(PostRequest $request){
        $request->validated();

        try{
            DB::beginTransaction();
            $post = Post::findOrFail($request->post_id);
            $this->commentAble($request);
            $post->update($request->except(['images', '_token', 'post_id']));

            if ($request->hasFile('images')) {
                ImageManager::deleteImages($post);
                ImageManager::uploadImages($request, $post);
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['errros'=>$e->getMessage()]);
        }

        Session::flash('success', 'Post Updated Successfuly!');
        return redirect()->route('frontend.dashboard.profile');
    }

    private function commentAble($request){
        return  $request->comment_able == "on" ? $request->merge(['comment_able'=>1])
                :$request->merge(['comment_able'=>0]);

    }
    public function deletePostImage(Request $request)
    {
        $image = Image::find($request->key);
        if (!$image) {
            return response()->json([
                'status' => '201',
                'msg' => 'Image Not Found',
            ]);
        }

        ImageManager::deleteImageFromLocal($image->path);
        $image->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'image deleted successfully',
        ]);
    }

    public function delete(Request $request){
        $post = Post::where('slug',$request->slug)->first();
        if(!$post){
            abort(404);
        }
        ImageManager::deleteImages($post);
        $post->delete();
        Cache::forget('read_more_posts');
        Cache::forget('latest_posts');
        return redirect()->back()->with('success','post deleted succsfully');
    }

    public function getComments($id){
        // $post = Post::findOrFail($id);
        // $comments = $post->comments()->get();

        $comments = Comment::with(['user'])->where('post_id',$id)->limit(5)->get();
        if(!$comments){
            return response()->json([
                'data'=>null,
                'msg' =>'no comments'
            ]);
        }
        return response()->json([
            'data'=>$comments,
            'msg' =>'contain comments'
        ]);
    }
}
