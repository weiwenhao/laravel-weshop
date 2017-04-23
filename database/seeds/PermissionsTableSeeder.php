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
        /*商品管理*/
        //一级
        $shop_admin =  Permission::create([
            'name' => 'shop_admin',
            'display_name' => '商品管理',
            'icon' => 'fa-shopping-cart',
            'sort' => 60,
        ]);
        //二级
        $goods = Permission::create([
            'name' => 'goods.list',
            'display_name' => '商品列表',
            'url' => 'goods',
            'parent_id' => $shop_admin->id,
            'description' => '商品列表',
        ]);
        //三级
        Permission::create([
            'name' => 'goods.create',
            'display_name' => '添加商品',
            'parent_id' => $goods->id,
            'description' => '添加商品',
        ]);
        Permission::create([
            'name' => 'goods.edit',
            'display_name' => '修改商品',
            'parent_id' => $goods->id,
            'description' => '修改商品',
        ]);
        Permission::create([
            'name' => 'goods.destroy',
            'display_name' => '删除商品',
            'parent_id' => $goods->id,
            'description' => '删除商品',
        ]);

        //二级
        $category = Permission::create([
            'name' => 'categories.list',
            'display_name' => '分类列表',
            'url' => 'categories',
            'parent_id' => $shop_admin->id,
            'description' => '分类列表',
        ]);
        //三级
        Permission::create([
            'name' => 'categories.create',
            'display_name' => '添加分类',
            'parent_id' => $category->id,
            'description' => '添加分类',
        ]);
        Permission::create([
            'name' => 'categories.edit',
            'display_name' => '修改分类',
            'parent_id' => $category->id,
            'description' => '修改分类',
        ]);
        Permission::create([
            'name' => 'categories.destroy',
            'display_name' => '删除分类',
            'parent_id' => $category->id,
            'description' => '删除分类',
        ]);

        //二级
        $attribute = Permission::create([
            'name' => 'attributes.list',
            'display_name' => '属性列表',
            'url' => 'categories',
            'parent_id' => $shop_admin->id,
            'description' => '属性列表',
        ]);
        //三级
        Permission::create([
            'name' => 'attributes.create',
            'display_name' => '添加属性',
            'parent_id' => $attribute->id,
            'description' => '添加属性',
        ]);
        Permission::create([
            'name' => 'attributes.edit',
            'display_name' => '修改属性',
            'parent_id' => $attribute->id,
            'description' => '修改属性',
        ]);
        Permission::create([
            'name' => 'attributes.destroy',
            'display_name' => '删除属性',
            'parent_id' => $attribute->id,
            'description' => '删除属性',
        ]);




        /**
         * 控制台系列
         */
        //顶级
        $dash =  Permission::create([
            'name' => 'dash',
            'display_name' => '控制台',
            'icon' => 'fa-dashboard',
            'sort' => 50,
        ]);
        //二级
        Permission::create([
            'name' => 'index',
            'display_name' => '主页',
            'url' => 'index',
            'parent_id' => $dash->id,
            'description' => '后台首页,主控制台',
        ]);







        /**
         * 系统设置
         */
        $site = Permission::create([
            'name' => 'dash',
            'display_name' => '系统设置',
            'icon' => 'fa-cog',
            'description' => '系统设置',
        ]);
        /**
         * 角色管理
         */
        $admin = Permission::create([
            'name' => 'admins.list',
            'display_name' => '用户列表',
            'url' => 'admins',
            'parent_id' => $site->id,
            'description' => '用户列表',
        ]);
        Permission::create([
            'name' => 'admins.create',
            'display_name' => '添加用户',
            'parent_id' => $admin->id,
            'description' => '添加用户',
        ]);
        Permission::create([
            'name' => 'admins.edit',
            'display_name' => '修改用户',
            'parent_id' => $admin->id,
            'description' => '修改用户',
        ]);
        Permission::create([
            'name' => 'admins.destroy',
            'display_name' => '删除用户',
            'parent_id' => $admin->id,
            'description' => '删除用户',
        ]);

        $role = Permission::create([
            'name' => 'roles.list',
            'display_name' => '角色列表',
            'url' => 'roles',
            'parent_id' => $site->id,
            'description' => '角色列表',
        ]);
        Permission::create([
            'name' => 'roles.create',
            'display_name' => '添加角色',
            'parent_id' => $role->id,
            'description' => '添加角色',
        ]);
        Permission::create([
            'name' => 'roles.edit',
            'display_name' => '修改角色',
            'parent_id' => $role->id,
            'description' => '修改角色',
        ]);
        Permission::create([
            'name' => 'roles.destroy',
            'display_name' => '删除角色',
            'parent_id' => $role->id,
            'description' => '删除角色',
        ]);

        $perm = Permission::create([
            'name' => 'permissions.list',
            'display_name' => '权限列表',
            'url' => 'permissions',
            'parent_id' => $site->id,
            'description' => '权限列表',
        ]);
        Permission::create([
            'name' => 'permissions.create',
            'display_name' => '添加权限',
            'parent_id' => $perm->id,
            'description' => '添加权限',
        ]);
        Permission::create([
            'name' => 'permissions.edit',
            'display_name' => '修改权限',
            'parent_id' => $perm->id,
            'description' => '修改权限',
        ]);
        Permission::create([
            'name' => 'permissions.destroy',
            'display_name' => '删除权限',
            'parent_id' => $perm->id,
            'description' => '删除权限',
        ]);

    }
}
