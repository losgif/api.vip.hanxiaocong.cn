<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolApplication extends Model
{
    public function school()
    {
        return $this->belongsToy(School::class);
    }
    
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function information()
    {
        return $this->hasMany(Information::class);
    }
}
