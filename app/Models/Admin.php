<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role_id',
        'status',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

public function posts()
    {
        return $this->hasMany(Post::class , 'admin_id');
    }
public function authorization()
    {
        return $this->belongsTo(Authorizations::class , 'role_id');
    }

    public function hasAccess($config_permession)  // products , users , admins
    {

        $authorizations = $this->authorization;

        if(!$authorizations){
            return false;
        }

        foreach($authorizations->permissions as $permession){
            if($config_permession == $permession ?? false){
                return true;
            }
        }

    }

        public function receivesBroadcastNotificationsOn(): string
    {
        return 'admins.'.$this->id;
    }

}
