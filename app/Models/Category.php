<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
{
    use HasFactory,Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];



    public function posts(){
        return $this->hasMany(Post::class,'category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [  // الحقل اللي في الداتا بيز
                'source' => 'name'  // الحقل اللي هعمل slug منه
            ]
        ];
    }

    public function scopeActive($query){
        $query->where('status',1);
    }
        public function status()
    {
        return $this->status == 1 ?'Active':'Not Active';
    }
}
