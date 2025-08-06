<?php

namespace App\Models;

use Psy\CodeCleaner\FinalClassPass;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
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

    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
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

}
