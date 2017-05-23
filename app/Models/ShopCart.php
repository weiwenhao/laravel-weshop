<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    protected $guarded = [];

    /**
     * 商品详情页加入购物车操作
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
     *得到购物车列表  无分页
     */
    public function getShopCarts()
    {
        $data = $this->select('goods.name', 'goods.price as goods_price', 'goods.is_sale', 'goods.sm_image', 'shop_carts.*',
            'numbers.price', 'numbers.number')
            ->join('goods', function ($join){
                $join->on('goods.id', '=', 'shop_carts.goods_id')
                    ->where('shop_carts.user_id', \Auth::user()->id);
            })
            ->leftJoin('numbers', function ($join){
                $join->on([ //on是对临时表的操作
                    ['shop_carts.goods_id', '=', 'numbers.goods_id'],
                    ['shop_carts.goods_attribute_ids', '=', 'numbers.goods_attribute_ids']
                ]);
            })
            ->get();
        //添加商品属性
        $order = new Order();
        $data = $data->map(function ($item) use ($order){
            $item->attr_name_values = $order->getAttrNameValues($item->goods_attribute_ids);
            return $item;
        });
        return $data;
    }

    /**
     * @param  array $shop_cart_ids 购物车列表id, 数组格式
     * @return string $err_msgs
     */
    public function checkShopCarts($shop_cart_ids)
    {
        $err_msgs = '';
        $order = new Order();
        //验证库存量商品语句
        foreach ($shop_cart_ids as $shop_cart_id){
            //检验该购物车id和用户id是否存在商品
            $shop_cart = $this->where('id', $shop_cart_id)->where('user_id', \Auth::user()->id)->first(); //如果连shop_carts_id都找不到,或者找到了不是当前用户的,我选择直接报错
            if(!$shop_cart){
                return  $err_msgs = '系统错误';
            }
            $err_msg = $order->checkOneGoods($shop_cart->goods_id, $shop_cart->goods_attribute_ids, $shop_cart->shop_number);
            if($err_msg){
                $err_msgs .= $err_msg."<br>";
            }
        }
        return $err_msgs;

    }

    /**
     * 将购物车中的数据存储到session中以供临时订单表使用
     * @param $shop_cart_ids
     * @return void
     */
    public function shopCartsToSession($shop_cart_ids)
    {
        $shop_carts = ShopCart::select('goods.name', 'goods.sm_image', 'shop_carts.shop_number',
            'shop_carts.goods_id', 'shop_carts.goods_attribute_ids')
            ->join('goods', function ($join) use ($shop_cart_ids){
                $join->on('goods.id', '=', 'shop_carts.goods_id')
                    ->whereIn('shop_carts.id', $shop_cart_ids);
            })->get(); //购买数量大于库存量的商品

        //判断当前用户是否存在默认的地址
        $addr = Addr::where([
            'user_id' => \Auth::user()->id,
            'is_default' => 1,
        ])->first();
        $order_addr_id = '';
        if($addr){
            $order_addr_id = $addr->id;
        }
        //将数组编辑成json格式 [{},{},{}]
        $order_goods = json_encode($shop_carts);
        //sesssion存储
        session(['order_addr_id' => $order_addr_id]);
        session(['order_goods' => $order_goods]);

    }


}