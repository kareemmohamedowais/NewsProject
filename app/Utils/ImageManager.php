<?php
namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImageManager{
    public static function uploadImages($request , $post=null,$user=null){
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                // store image in public
                $filename = self::generateImageName($image);
                $path  = self::storeImageInLocal($image,'posts',$filename);
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
            if($request->hasFile('image')){
            $image = $request->file('image');
            // delete image from local
            self::deleteImageFromLocal($user->image);

            // store image in local
            $filename = self::generateImageName($image);
            $path  = self::storeImageInLocal($image,'users',$filename);
            // update in database
            $user->update(['image'=>$path]);
        }

    }
    public static function deleteImages($post){
        if($post->images->count()>0){
            foreach ($post->images as $image) {
                self::deleteImageFromLocal($image->path);
                $image->delete();
            }
        }
    }
    private static function generateImageName($image){
        $filename = Str::uuid(). time().'.'.$image->getClientOriginalExtension();
        return $filename;
    }
    private static function storeImageInLocal($image,$path,$filename){
        $path  = $image->storeAs('uploads/'.$path,$filename,['disk'=>'uploads']);
        return $path;
    }
    public static function deleteImageFromLocal($image_path){
            if(File::exists(public_path($image_path))){
                    File::delete(public_path($image_path));
            }
    }


}




