<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class shopCartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\shopCart::create([
            'user_id' => '1',
            'goods_id' => 2,
            'shop_number' => 100,
        ]);

        $anzhuo = DB::table('goods_attributes')->where('attribute_value', '安卓')->first();
        $ios = DB::table('goods_attributes')->where('attribute_value', 'ios')->first();
        \App\Models\shopCart::create([
            'user_id' => '1',
            'goods_id' => 1,
            'goods_attribute_ids' => $anzhuo->id, //所有的可选属性
            'shop_number' => 50,
        ]);

        \App\Models\shopCart::create([
            'user_id' => '1',
            'goods_id' => 1,
            'goods_attribute_ids' => $ios->id, //所有的可选属性
            'shop_number' => 50,
        ]);

    }
}
