<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
