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

    //被赋过值的订单模型才能调用该方法  特别注意,该模型中包含连表之后的数据
    public function orderContent()
    {
         //得到一个分行数据即可
            //得到商品名称
            $res = $goods_name = str_limit($this->goods_name,15);
            //得到shop_number
            $res .= '&nbsp; x'.$this->shop_number;
            $res .= '<br>';
            //得到商品可选属性搭配 格式 -> "厂商:小米,操作系统:安卓"
            if($this->goods_attribute_ids){
                $res .= $this->getAttrNameValues($this->goods_attribute_ids);
                $res .= '<br>';
            }
            $res .= '单价:'.$this->shop_price;
            return $res;
    }

    /**
     * 根据商品属性id得到商品的属性数据,主要用于聚合展示,不适用于购买时的选择
     * @param $goods_attr_ids
     * @param string $connector
     * @return string
     */
    public function getAttrNameValues($goods_attr_ids, $connector = '；'){
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
        })->implode($connector);
        return $attr_name_values;
    }
}
