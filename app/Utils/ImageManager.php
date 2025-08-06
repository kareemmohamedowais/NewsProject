<?php
namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImageManager{
    public static function uploadImages($request , $post){
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                // store image in public
                $filename = Str::uuid(). time().'.'.$image->getClientOriginalExtension();
                $path  =$image->storeAs('uploads/posts',$filename,["disk"=>'uploads']);
                //store images in database
                $post->images()->create([
                    'path'=>$path
                ]);
                // store images in database 2
                // Image::create([
                //     'post_id'=>$post->id,
                //     'path'=>$path
                // ]);

            }
        }

    }
    public static function deleteImages($post){
        if($post->images->count()>0){
            foreach ($post->images as $image) {
                if(File::exists(public_path($image->path))){
                    File::delete(public_path($image->path));
                }
            }
        }
    }
}




