<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $weiwenhao = \App\Models\Admin::create([
            'name' => 'weiwenhao',
            'email' => '1101140857@qq.com',
            'password' => '123456',
        ]);
        //分配角色
        $admin = \App\Models\Role::where('name','admin')->first();
        $weiwenhao->roles()->attach($admin->id); //超级管理员
    }
}
