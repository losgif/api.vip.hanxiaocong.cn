<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolApplicationKeyword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_application_id', 'keyword'
    ];

    /**
     * 查询所属公众号下应用
     *
     * @return SchoolApplication
     */
    public function schoolApplication()
    {
        return $this->belongsTo(SchoolApplication::class, 'school_application_id');
    }
}
