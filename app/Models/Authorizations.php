<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorizations extends Model
{
    use HasFactory;
    protected $fillable = ['role','permissions'];

public function getPermissionsAttribute($permissions)
{
    return json_decode($permissions, true) ?? [];
}


public function admins()
    {
        return $this->hasMany(Admin::class , 'role_id');
    }
}
