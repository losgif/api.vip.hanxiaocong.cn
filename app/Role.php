<?php

namespace App;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
