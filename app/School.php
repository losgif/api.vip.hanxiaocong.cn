<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * 查询信息
     *
     * @return Info
     */
    public function info()
    {
        return $this->hasMany(Info::class);
    }

    /**
     * 查询信息
     *
     * @return Info
     */
    public function information()
    {
        return $this->hasManyThrough(Information::class, SchoolApplication::class);
    }

    /**
     * 查询所属用户
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 查询所属关键字
     *
     * @return SchoolApplicationKeyword
     */
    public function keyword()
    {
        return $this->hasManyThrough(SchoolApplicationKeyword::class, SchoolApplication::class);
    }

    /**
     * 查询所有启用应用
     *
     * @return SchoolApplication
     */
    public function schoolApplication()
    {
        return $this->hasMany(SchoolApplication::class);
    }
}
