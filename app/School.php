<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function info()
    {
        return $this->hasMany(Info::class);
    }
}
