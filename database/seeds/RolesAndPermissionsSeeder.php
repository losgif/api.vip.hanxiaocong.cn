<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
   public function run()
   {
       // 重置角色和权限缓存
       app()['cache']->forget('spatie.permission.cache');

       // 创建 Application 权限
       Permission::create(['name' => 'create applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'update applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'select applications', 'guard_name' => 'api']);

       // 创建 School 权限
       Permission::create(['name' => 'create schools', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete schools', 'guard_name' => 'api']);
       Permission::create(['name' => 'update schools', 'guard_name' => 'api']);
       Permission::create(['name' => 'select schools', 'guard_name' => 'api']);

       // 创建 SchoolApplication 权限
       Permission::create(['name' => 'create school applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete school applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'update school applications', 'guard_name' => 'api']);
       Permission::create(['name' => 'select school applications', 'guard_name' => 'api']);

       // 创建 SchoolApplicationKeyword 权限
       Permission::create(['name' => 'create school application keywords', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete school application keywords', 'guard_name' => 'api']);
       Permission::create(['name' => 'update school application keywords', 'guard_name' => 'api']);
       Permission::create(['name' => 'select school application keywords', 'guard_name' => 'api']);

       // 创建 Information 权限
       Permission::create(['name' => 'create informations', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete informations', 'guard_name' => 'api']);
       Permission::create(['name' => 'update informations', 'guard_name' => 'api']);
       Permission::create(['name' => 'select informations', 'guard_name' => 'api']);

       // 创建 User 权限
       Permission::create(['name' => 'create users', 'guard_name' => 'api']);
       Permission::create(['name' => 'delete users', 'guard_name' => 'api']);
       Permission::create(['name' => 'update users', 'guard_name' => 'api']);
       Permission::create(['name' => 'select users', 'guard_name' => 'api']);

       // 创建 vistor 角色并分配创建的权限
       $role = Role::create(['name' => 'vistor', 'guard_name' => 'api']);
       $role->givePermissionTo([
            'create schools',

            'create users',
            'update users',
            'delete users',
            'select users',
       ]);

       // 创建 normal-user 角色并分配创建的权限
       $role = Role::create(['name' => 'normal-user', 'guard_name' => 'api']);
       $role->givePermissionTo([
            'create schools',
            'update schools',
            'delete schools',
            'select schools',

            'create school applications',
            'update school applications',
            'delete school applications',
            'select school applications',

            'create school application keywords',
            'update school application keywords',
            'delete school application keywords',
            'select school application keywords',

            'create informations',
            'update informations',
            'delete informations',
            'select informations',
            
            'create users',
            'update users',
            'delete users',
            'select users',
       ]);

       // 创建 super-admin 角色并分配创建的权限
       $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
       $role->givePermissionTo(Permission::all());
   }
}
