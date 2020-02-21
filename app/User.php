<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable, SoftDeletes;

    Protected $guard_name ='api';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取用户对应权限
     *
     * @return Role
     */
    public function role()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    public function school()
    {
        return $this->hasMany(School::class);
    }

    public function info()
    {
        return $this->hasManyThrough(Info::class, School::class);
    }

    public function information()
    {
        return $this->hasManyThrough(Information::class, School::class);
    }

    public function application()
    {
        return $this->hasManyThrough(SchoolApplication::class, School::class);
    }
}
