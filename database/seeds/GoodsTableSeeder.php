<?php

use App\Models\Goods;
use Illuminate\Database\Seeder;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ceshi1 = Goods::create([
            'name' => '测试商品1',
            'price' => 99.99,
            'image' => '/uploads/images/goods/20170425/wKFXxfMQ6YroOwL1.jpg',
            'sm_image' => '/uploads/images/goods/20170425/sm_wKFXxfMQ6YroOwL1.jpg',
            'mid_image' => '/uploads/images/goods/20170425/mid_wKFXxfMQ6YroOwL1.jpg',
            'big_image' => '/uploads/images/goods/20170425/big_wKFXxfMQ6YroOwL1.jpg',
            'category_id' => 1,
            'type_id' => 1,
        ]);

        $ceshi2 = Goods::create([
            'name' => '测试商品2',
            'price' => 10.00,
            'image' => '/uploads/images/goods/20170425/h72IjfZ1BahqZBn8.jpg',
            'sm_image' => '/uploads/images/goods/20170425/sm_h72IjfZ1BahqZBn8.jpg',
            'mid_image' => '/uploads/images/goods/20170425/mid_h72IjfZ1BahqZBn8.jpg',
            'big_image' => '/uploads/images/goods/20170425/big_h72IjfZ1BahqZBn8.jpg',
            'category_id' => 1,
        ]);
    }
}
