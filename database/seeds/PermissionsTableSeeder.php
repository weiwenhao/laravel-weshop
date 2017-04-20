<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * RABC
         */
        $rabc = Permission::create([
            'name' => 'dash',
            'display_name' => '控制台',
            'icon' => 'fa-unlock',
            'description' => '控制台',
        ]);

        /**
         * 角色管理
         */
        $admin = Permission::create([
            'name' => 'admin.list',
            'display_name' => '用户列表',
            'url' => 'admin',
            'parent_id' => $rabc->id,
            'description' => '用户列表',
        ]);
        Permission::create([
            'name' => 'admin.create',
            'display_name' => '添加用户',
            'parent_id' => $admin->id,
            'description' => '添加用户',
        ]);
        Permission::create([
            'name' => 'admin.edit',
            'display_name' => '修改用户',
            'parent_id' => $admin->id,
            'description' => '修改用户',
        ]);
        Permission::create([
            'name' => 'admin.destroy',
            'display_name' => '删除用户',
            'parent_id' => $admin->id,
            'description' => '删除用户',
        ]);

        $role = Permission::create([
            'name' => 'role.list',
            'display_name' => '角色列表',
            'url' => 'role',
            'parent_id' => $rabc->id,
            'description' => '角色列表',
        ]);
        Permission::create([
            'name' => 'role.create',
            'display_name' => '添加角色',
            'parent_id' => $role->id,
            'description' => '添加角色',
        ]);
        Permission::create([
            'name' => 'role.edit',
            'display_name' => '修改角色',
            'parent_id' => $role->id,
            'description' => '修改角色',
        ]);
        Permission::create([
            'name' => 'role.destroy',
            'display_name' => '删除角色',
            'parent_id' => $role->id,
            'description' => '删除角色',
        ]);

        $perm = Permission::create([
            'name' => 'permission.list',
            'display_name' => '权限列表',
            'url' => 'permission',
            'parent_id' => $rabc->id,
            'description' => '权限列表',
        ]);
        Permission::create([
            'name' => 'permission.create',
            'display_name' => '添加权限',
            'parent_id' => $perm->id,
            'description' => '添加权限',
        ]);
        Permission::create([
            'name' => 'permission.edit',
            'display_name' => '修改权限',
            'parent_id' => $perm->id,
            'description' => '修改权限',
        ]);
        Permission::create([
            'name' => 'permission.destroy',
            'display_name' => '删除权限',
            'parent_id' => $perm->id,
            'description' => '删除权限',
        ]);

    }
}
