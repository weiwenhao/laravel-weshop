<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['is_pay', 'status'];


    public function orderGoods(){
        return $this->hasMany(OrderGoods::class, 'order_id', 'id');
    }

    /*public function goods()
    {
        return $this->belongsToMany(Goods::class, 'order_goods', 'order_id', 'goods_id');
    }*/

    //被赋过值的订单模型才能调用该方法
    public function orderContent()
    {
        $orderGoods = $this->orderGoods; //通过关联关系,得到商品中的订单 , 当然也可以使用 DB::table进行查询
        return $orderGoods->map(function ($item){ //得到一个分行数据即可
            //得到商品名称
            $res = $goods_name = str_limit(Goods::find($item->goods_id)->name,10);
            $res .= '&nbsp;&nbsp;&nbsp;';
            //得到商品可选属性搭配 格式 -> "厂商:小米,操作系统:安卓"
            $res .= $this->attrNameValues($item->goods_attribute_ids);
            $res .= '&nbsp;&nbsp;&nbsp;';
            //得到shop_number
            $res .= 'x'.$item->shop_number;
            return $res;
        })->implode('<br>');
    }

    private function attrNameValues($goods_attr_ids){
        if(!is_array($goods_attr_ids)){
            $goods_attr_ids = explode(',', $goods_attr_ids);
        }
        $goods_attributes = DB::table('goods_attributes')
            ->select('goods_attributes.id', 'attributes.name', 'goods_attributes.attribute_value')
            ->join('attributes', 'goods_attributes.attribute_id', '=', 'attributes.id')
            ->whereIn('goods_attributes.id', $goods_attr_ids)->get(); //集合

        $attr_name_values = $goods_attributes->map(function ($item){
            //拼接出一条
            return $item->name.'：'.$item->attribute_value;
        })->implode('，');
        return $attr_name_values;
    }
}
