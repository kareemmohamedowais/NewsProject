<?php
namespace App\Utils;

use Illuminate\Support\Str;

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
}




