<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function applicationPlatform()
    {
        return $this->hasMany(ApplicationPlatform::class);
    }
}
