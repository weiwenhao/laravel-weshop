<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    protected $guarded = [];

    /**
     * 加入购物车操作
     * @return mixed
     */
    public function storeShopCart()
    {
        $user_id = session('wechat.oauth_user')->id;
        $goods_id = request('goods_id');
        $goods_attribute_ids = implode(',', request('goods_attribute_ids', []));
        $arr = [
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'goods_attribute_ids' => $goods_attribute_ids,
        ];

        $shop_cart = $this->where($arr)->first();
        if ($shop_cart){
            //已经存在则进行增加
            $shop_cart->increment('number');
        }else{
            $shop_cart = ShopCart::create($arr); //创建的时候并不包含number,因此首次加入购物车时并不具备选数量的功能
        }
        return $shop_cart;
    }

    /**
     *购物车列表
     */
    public function getShopCarts()
    {
        $data = $this->leftJoin('goods', 'goods.id', '=', 'shop_carts.goods_id')->select('goods.name', 'shop_carts.*')->get();
        //添加商品属性
        $order = new Order();
        $data = $data->map(function ($item) use ($order){
            $item->attribute_name_values = $order->getAttrNameValues($item->goods_attribute_ids);
            return $item;
        });
        return $data;
    }

}
