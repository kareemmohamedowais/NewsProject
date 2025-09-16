<?php

namespace App\Models;

use App\Models\Admin;
use Psy\CodeCleaner\FinalClassPass;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'comment_able',
        'num_of_views',
        'status',
        'category_id',
        'user_id',
        'admin_id',

    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }
    public function images(){
        return $this->hasMany(Image::class,'post_id');
    }


    public function sluggable(): array
    {
        return [
            'slug' => [  // الحقل اللي في الداتا بيز
                'source' => 'title'  // الحقل اللي هعمل slug منه
            ]
        ];
    }
    public function scopeActive($query){
        $query->where('status',1);
    }

public function scopeActiveUser($query)
    {
        $query->where(function($query){
            $query->whereHas('user' , function($user){
                $user->whereStatus(1);
            })->orWhere('user_id' , null);
        });
    }
    public function scopeActiveCategory($query)
    {
        $query->whereHas('category' , function($user){
            $user->whereStatus(1);
        });
    }
    // public function getStatusAttribute()
    // {
    //     return $this->attributes['status'] == 1 ?'Active':'Not Active';
    // }
//     public function setStatusAttribute($value)
// {
//     $this->attributes['status'] = $value === 'Active' ? 1 : 0;
// }

//  protected function status()
//     {
//         return Attribute::make(
//             get: fn ($value) => $value == 1 ? 'Active' : 'Not Active',
//             set: fn ($value) => $value === 'Active' ? 1 : 0,
//         );
//     }

    public function status()
    {
        return $this->status == 1 ?'Active':'Not Active';
    }
}
