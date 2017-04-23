<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => '手机'
        ]);
        Type::create([
            'name' => '套餐'
        ]);
        Type::create([
            'name' => '耳机'
        ]);
        Type::create([
            'name' => '水果'
        ]);
        Type::create([
            'name' => '饮品'
        ]);
    }
}
