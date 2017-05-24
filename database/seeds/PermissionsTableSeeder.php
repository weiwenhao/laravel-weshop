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
        /*************************商品管理***************************************/
        //一级
        $shop_admin =  Permission::create([
            'name' => 'shop_admin',
            'display_name' => '商品管理',
            'icon' => 'fa-shopping-bag',
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

        //库存管理, 特殊-> 3级
        $number = Permission::create([
            'name' => 'numbers.list',
            'display_name' => '库存列表',
            'parent_id' => $goods->id,
        ]);


        //商品评论管理->上级是商品列表
        $goods_comment = Permission::create([
            'name' => 'goods_comments.list',
            'display_name' => '商品评论列表',
            'parent_id' => $goods->id,
        ]);
        Permission::create([
            'name' => 'goods_comments.destroy',
            'display_name' => '删除商品评论',
            'parent_id' => $goods_comment->id,
            'description' => '删除商品评论',
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
        $type = Permission::create([
            'name' => 'types.list',
            'display_name' => '类型列表',
            'url' => 'types',
            'parent_id' => $shop_admin->id,
            'description' => '类型列表',
        ]);
        //三级
        Permission::create([
            'name' => 'types.create',
            'display_name' => '添加类型',
            'parent_id' => $type->id,
            'description' => '添加类型',
        ]);
        Permission::create([
            'name' => 'types.edit',
            'display_name' => '修改类型',
            'parent_id' => $type->id,
            'description' => '修改类型',
        ]);
        Permission::create([
            'name' => 'types.destroy',
            'display_name' => '删除类型',
            'parent_id' => $type->id,
            'description' => '删除类型',
        ]);

        //商品属性管理, 特殊=> 3级
        $attr = Permission::create([
            'name' => 'attributes.list',
            'display_name' => '属性列表',
            'parent_id' => $type->id,
            'description' => '添加类型',
        ]);
        //4级
        Permission::create([
            'name' => 'attributes.create',
            'display_name' => '添加属性',
            'parent_id' => $attr->id,
            'description' => '添加属性',
        ]);
        Permission::create([
            'name' => 'attributes.edit',
            'display_name' => '修改属性',
            'parent_id' => $attr->id,
            'description' => '修改属性',
        ]);
        Permission::create([
            'name' => 'attributes.destroy',
            'display_name' => '删除属性',
            'parent_id' => $attr->id,
            'description' => '删除属性',
        ]);

        //回收站
        $huishouzhan = Permission::create([
            'name' => 'goods.list',
            'display_name' => '回收站',
            'url' => 'deled_goods',
            'parent_id' => $shop_admin->id,
            'description' => '回收站',
        ]);

        /**************************订单管理***************************************/
        //一级
        $order_admin =  Permission::create([
            'name' => 'order_admin',
            'display_name' => '订单管理',
            'icon' => 'fa-jpy',
            'sort' => 70,
        ]);


        //二级 所有订单管理
        $order = Permission::create([
            'name' => 'orders.list',
            'display_name' => '订单列表',
            'url' => 'orders',
            'parent_id' => $order_admin->id,
            'description' => '订单列表',
        ]);
        Permission::create([ //相关订单的url请手动将需要的route_name 设置为 orders.edit,已方便权限的管理
            'name' => 'orders.edit',
            'display_name' => '修改订单',
            'parent_id' => $order->id,
            'description' => '修改订单',
        ]);

        //二级 水果订单管理
        $fruit_order = $order = Permission::create([
            'name' => 'fruit_orders.list',
            'display_name' => '水果订单',
            'url' => 'fruit_orders',
            'parent_id' => $order_admin->id,
            'description' => '水果订单',
        ]);
        Permission::create([
            'name' => 'fruit_orders.edit', //水果相关订单的url请手动将需要的route_name 设置为 orders.edit,已方便权限的管理
            'display_name' => '修改水果订单',
            'parent_id' => $order->id,
            'description' => '修改水果订单',
        ]);


        //地址管理
        $addr = Permission::create([
            'name' => 'addrs.list',
            'display_name' => '地址列表',
            'url' => 'addrs',
            'parent_id' => $order_admin->id,
            'description' => '地址列表',
        ]);
        /*Permission::create([
            'name' => 'addrs.edit',
            'display_name' => '修改地址',
            'parent_id' => $addr->id,
            'description' => '修改地址',
        ]);*/
        Permission::create([
            'name' => 'addrs.destroy',
            'display_name' => '删除地址',
            'parent_id' => $addr->id,
            'description' => '删除地址',
        ]);


        /*****************************圈子(circle)管理************************************/
        $circle_admin =  Permission::create([
            'name' => 'circle_admin',
            'display_name' => '圈子管理',
            'icon' => 'fa-circle',
            'sort' => 80,
        ]);
        $post = Permission::create([
            'name' => 'posts.list',
            'display_name' => '帖子列表',
            'url' => 'posts',
            'parent_id' => $circle_admin->id,
        ]);
        Permission::create([
            'name' => 'posts.destroy',
            'display_name' => '删除帖子',
            'parent_id' => $post->id,
        ]);

        //板块管理
        $post_category = Permission::create([
            'name' => 'post_categories.list',
            'url' => 'post_categories',
            'display_name' => '板块列表',
            'parent_id' => $circle_admin->id,
        ]);
        Permission::create([
            'name' => 'post_categories.create',
            'display_name' => '添加板块',
            'parent_id' => $post_category->id,
        ]);
        Permission::create([
            'name' => 'post_categories.edit',
            'display_name' => '修改板块',
            'parent_id' => $post_category->id,
        ]);
        Permission::create([
            'name' => 'post_categories.destroy',
            'display_name' => '删除板块',
            'parent_id' => $post_category->id,
        ]);

        //评论管理, 特殊=> 3级
        $comment = Permission::create([
            'name' => 'comments.list',
            'display_name' => '评论列表',
            'parent_id' => $post->id,
        ]);
        //4级
        Permission::create([
            'name' => 'comments.destroy',
            'display_name' => '删除评论',
            'parent_id' => $comment->id,
        ]);
        /****************************活动管理**********************************************/
        $active_admin =  Permission::create([
            'name' => 'active_admin',
            'display_name' => '活动管理',
            'icon' => 'fa-tree',
            'sort' => 80,
        ]);

        //二级
        $active = Permission::create([
            'name' => 'actives.list',
            'display_name' => '活动列表',
            'url' => 'actives',
            'parent_id' => $active_admin->id,
            'description' => '活动列表',
        ]);

        //三级
        Permission::create([
            'name' => 'actives.create',
            'display_name' => '添加活动',
            'parent_id' => $active->id,
            'description' => '添加活动',
        ]);
        Permission::create([
            'name' => 'actives.edit',
            'display_name' => '修改活动',
            'parent_id' => $active->id,
            'description' => '修改活动',
        ]);
        Permission::create([
            'name' => 'actives.destroy',
            'display_name' => '删除活动',
            'parent_id' => $active->id,
            'description' => '删除活动',
        ]);
        //四级五级

        /*****************************控制台************************************/
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

        //二级
        Permission::create([
            'name' => 'compute',
            'display_name' => '订单统计',
            'url' => 'compute',
            'parent_id' => $dash->id,
            'description' => '统计台',
        ]);





        /*****************************控制台************************************/
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
