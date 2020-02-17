<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolKeyword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id', 'keyword'
    ];

    /**
     * 查询所属公众号
     *
     * @return School
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
