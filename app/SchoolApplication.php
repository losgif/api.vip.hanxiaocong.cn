<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolApplication extends Model
{
    use SoftDeletes;

    /**
     * 查询学校
     *
     * @return School
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    /**
     * 查询应用
     *
     * @return Application
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * 查询信息
     *
     * @return Information
     */
    public function information()
    {
        return $this->hasMany(Information::class);
    }

    /**
     * 查询关键词
     *
     * @return SchoolApplicationKeyword
     */
    public function keyword()
    {
        return $this->hasMany(SchoolApplicationKeyword::class);
    }

    /**
     * 配置修改器
     *
     * @param json $config
     * @return Object
     */
    public function getConfigAttribute($config)
    {
        return json_decode($config);
    }
}
