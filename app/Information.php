<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    public function application()
    {
        return $this->belongsTo(SchoolApplication::class, 'school_application_id');
    }
}
