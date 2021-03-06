<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use SoftDeletes;
    
    public function application()
    {
        return $this->belongsTo(SchoolApplication::class, 'school_application_id');
    }

    public function getExtraAttribute($extra)
    {
        return json_decode($extra);
    }
}
