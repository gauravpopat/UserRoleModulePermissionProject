<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
<<<<<<< HEAD
=======

use App\Models\RolePermission;
use App\Models\UserRole;
>>>>>>> develop
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified',
        'email_verification_code',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin'  => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles','user_id','role_id');
    }
<<<<<<< HEAD
=======

    public function permissions()
    {
        return $this->hasManyThrough(RolePermission::class,UserRole::class,'user_id','role_id');
    }
>>>>>>> develop
}
