<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
    	return $this->hasMany(Post::class);
    }
   /* public static roleHaspermissions($role, $permissions)
    {
    	$hasPermission = true;
    	foreach ($permissions as $permission) {
    		if(!$role->hasPermissionTo($permission->name)){
    	      $hasPermission = false;
    	      return $hasPermission;
    		}
    	}
    	return $hasPermission;
    }*/
}
