<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role;
        $admin->name = 'admin';
        $admin->display_name = '超级管理员';
        $admin->description = '超级管理员';
        $admin->save();

        $user = new Role;
        $user->name = 'user';
        $user->display_name = '普通用户';
        $user->description = '普通用户';
        $user->save();
        //为超级管理员添加所有权限(先填充权限)
        $allPermission = array_column(Permission::all()->toArray(), 'id'); // [1,3,4]
        $admin->perms()->sync($allPermission); //给admin用户同步所有权限
        // 普通管理
        $rabc = Permission::where('display_name','RABC')->first();
        $permList = Permission::where('display_name','权限列表')->first();
        $permCreate = Permission::where('name','permission.create')->first();
        $roleList = Permission::where('name','role.list')->first();
        $user->attachPermissions([$permList,$permCreate,$roleList,$rabc]); //entrust自带的添加多对多的方法,直接填入模型

    }
}
