<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    protected $guarded = [];

    /**
     * 加入购物车操作
     * @param $goods_id
     * @param $goods_attribute_ids
     * @param $shop_number
     * @return mixed
     */
    public function storeShopCart($goods_id, $goods_attribute_ids, $shop_number)
    {
        $user_id = \Auth::user()->id;
        $arr = [
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'goods_attribute_ids' => $goods_attribute_ids,
        ];
        $shop_cart = $this->where($arr)->first();
        if ($shop_cart){//已经存在则进行增加
            $shop_cart->increment('shop_number', $shop_number);
        }else{
            $arr['shop_number'] = $shop_number;
            $shop_cart = ShopCart::create($arr);
        }
        return $shop_cart;
    }

    /**
     *购物车列表
     */
    public function getShopCarts()
    {
        $data = $this->select('goods.name', 'goods.price as goods_price', 'goods.is_on_sale', 'goods.sm_image', 'shop_carts.*',
            'numbers.price', 'numbers.number')
            ->join('goods', function ($join){
                $join->on('goods.id', '=', 'shop_carts.goods_id')
                    ->where('shop_carts.user_id', \Auth::user()->id);
            })
            ->leftJoin('numbers', function ($join){
                $join->on([ //on是对临时表的操作
                    ['shop_carts.goods_id', '=', 'numbers.goods_id'],
                    ['shop_carts.goods_attribute_ids', '=', 'numbers.goods_attribute_ids']
                ])->orWhereNull('numbers.goods_attribute_ids');
            })
            ->get();
        dd($data->toArray());
        //添加商品属性
        $order = new Order();
        $data = $data->map(function ($item) use ($order){
            $item->attr_name_values = $order->getAttrNameValues($item->goods_attribute_ids);
            return $item;
        });
        return $data;
    }

    /*public function setGoodsAttributeIdsAttribute($value)
    {
            if(!is_array($value))
                explode(',', $value);
            sort($value, 1); //1代表 SORT_NUMRIC 把每一项当作数字来处理
            $this->attributes['goods_attribute_ids'] = implode(',', $value);;
    }*/

}
