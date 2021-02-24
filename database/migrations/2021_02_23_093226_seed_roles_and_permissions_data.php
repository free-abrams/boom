<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 先创建权限
        Permission::create(['name' => 'auth_manage', 'guard_name' => 'admin', 'title' => '角色与权限', 'route' => null, 'sort' => '10', 'level' => 0, 'path' => '-']);
        Permission::create(['name' => 'role_manage', 'guard_name' => 'admin', 'title' => '角色管理', 'route' => 'role.*', 'sort' => '9', 'level' => 1, 'path' => '-1-', 'parent_id' => 1]);
        Permission::create(['name' => 'permission_manage', 'guard_name' => 'admin', 'title' => '权限管理', 'route' => 'permission.*', 'sort' => 8, 'level' => 1, 'path' => '-1-', 'parent_id' => 1]);

        // 创建站长角色，并赋予权限
        $founder = Role::create(['name' => 'super_admin', 'guard_name' => 'admin', 'title' => '超级管理员']);
        $founder->givePermissionTo('auth_manage');
        $founder->givePermissionTo('role_manage');
        $founder->givePermissionTo('permission_manage');

        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => 'admin', 'guard_name' => 'admin', 'title' => '管理员']);
        $maintainer->givePermissionTo('auth_manage');
        $founder->givePermissionTo('role_manage');
    }

    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
