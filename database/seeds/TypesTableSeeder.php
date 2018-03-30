<?php

use App\Models\Attribute;
use App\Models\Goods;
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
        $phone =  Type::create([
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
        $yinpin = Type::create([
            'name' => '饮品'
        ]);

        //商品属性seed
        $changshang = Attribute::create([
            'name' => '厂商',
            'type' => '唯一',
//            'option_values' => null,
            'type_id' => $phone->id,
        ]);

        $caozuo = Attribute::create([
            'name' => '操作系统',
            'type' => '可选',
            'option_values' => '安卓,ios,wp',
            'type_id' => $phone->id,
        ]);

        Attribute::create([
            'name' => '颜色',
            'type' => '可选',
            'option_values' => '白色,银色,星空灰,土豪金,玫瑰金,苹果绿',
            'type_id' => $phone->id,
        ]);


        Attribute::create([
            'name' => '口味',
            'type' => '可选',
//            'option_values' => null,
            'type_id' => $yinpin->id,
        ]);

        Attribute::create([
            'name' => '毫升',
            'type' => '可选',
            'option_values' => '700ml,900ml,1200ml',
            'type_id' => $yinpin->id,
        ]);

          $ceshi1 = Goods::where('id',1)->first();
        //goods_attribute表填充
        $goods_attr1 = \Illuminate\Support\Facades\DB::table('goods_attributes')->insert([
            'goods_id' => $ceshi1->id,
            'attribute_id' => $changshang->id,
            'attribute_value' => '小米'
        ]);

        \Illuminate\Support\Facades\DB::table('goods_attributes')->insert([
            'goods_id' => $ceshi1->id,
            'attribute_id' => $caozuo->id,
            'attribute_value' => 'ios'
        ]);

        \Illuminate\Support\Facades\DB::table('goods_attributes')->insert([
            'goods_id' => $ceshi1->id,
            'attribute_id' => $caozuo->id,
            'attribute_value' => '安卓'
        ]);
    }
}
