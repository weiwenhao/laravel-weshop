<?php

use App\Models\Goods;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //填充一条地址
        $addr = \App\Models\Addr::create([
            'name' => '魏文豪',
            'phone' => '13168065609',
            'garden_name' => '积善园',
            'floor_name' => '孝悌楼',
            'number' => '503',
            'user_id' => '1'
        ]);

        //填充一条记录
        $order1 = \App\Models\Order::create([
            'order_id' =>  date('ymdhi').sprintf('%04d', mt_rand(1,9999)),
            'remarks' => '我是订单备注',
            'user_id' => '1',
            'name' => $addr->name,
            'phone' => $addr->phone,
            'garden_name' => $addr->garden_name,
            'floor_name' => $addr->floor_name,
            'number' => $addr->number,
            'total_price' => 55,
        ]);

        $order2 = \App\Models\Order::create([
            'order_id' =>  date('ymdhi').sprintf('%04d', mt_rand(1,9999)),
            'remarks' => '我是订单备注啊',
            'user_id' => '1',
            'name' => $addr->name,
            'phone' => $addr->phone,
            'garden_name' => $addr->garden_name,
            'floor_name' => $addr->floor_name,
            'number' => $addr->number,
            'total_price' => 89,
        ]);

        //填充订单商品2条
        $ceshi1 = Goods::where('id',1)->first();
        $anzhuo = DB::table('goods_attributes')->where('attribute_value', '安卓')->first();
        $ios = DB::table('goods_attributes')->where('attribute_value', 'ios')->first();
        \App\Models\OrderGoods::create([
            'order_id' => $order1->id,
            'goods_id' => $ceshi1->id,
            'goods_attribute_ids' => $anzhuo->id,
            'shop_number' => '3',
            'shop_price' => $ceshi1->price,
        ]);
        \App\Models\OrderGoods::create([
            'order_id' => $order1->id,
            'goods_id' => $ceshi1->id,
            'goods_attribute_ids' => $ios->id,
            'shop_number' => '2',
            'shop_price' => $ceshi1->price,
        ]);


        $ceshi2 = Goods::where('id',2)->first();
        \App\Models\OrderGoods::create([
            'order_id' => $order1->id,
            'goods_id' => $ceshi2->id,
            'shop_number' => '1',
            'shop_price' => $ceshi2->price,
        ]);

        \App\Models\OrderGoods::create([
            'order_id' => $order2->id,
            'goods_id' => $ceshi2->id,
            'shop_number' => '2',
            'shop_price' => $ceshi2->price,
        ]);

    }
}
