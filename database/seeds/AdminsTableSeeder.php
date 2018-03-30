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
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => 'admin',
        ]);
        //分配角色
        $admin = \App\Models\Role::where('name','admin')->first();
        $weiwenhao->roles()->attach($admin->id); //超级管理员
    }
}
