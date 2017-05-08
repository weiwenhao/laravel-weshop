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
     *得到购物车列表  无分页
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
     * 购物车中结算后, 对商品数据进行一个检验, 返回一个数组,
     * @param $shop_cart_ids
     * @return array  $arr['sucs'] 中是通过验证的商品,  $arr['errs'] 是库存量不足的错误信息
     */
    public function checkShopCarts($shop_cart_ids)
    {
        //验证库存量商品语句
        $shop_carts = ShopCart::select('goods.name', 'goods.is_on_sale', 'goods.sm_image', 'shop_carts.shop_number', 'shop_carts.id',
            'shop_carts.goods_id', 'shop_carts.goods_attribute_ids' ,'numbers.number')
            ->join('goods', function ($join) use ($shop_cart_ids){
                $join->on('goods.id', '=', 'shop_carts.goods_id')
                    ->whereIn('shop_carts.id', $shop_cart_ids);
            }) ->join('numbers', function ($join){
                $join->on([ //on是对临时表的操作
                    ['shop_carts.goods_id', '=', 'numbers.goods_id'],
                    ['shop_carts.goods_attribute_ids', '=', 'numbers.goods_attribute_ids']
                ]);
            })/*->whereColumn('shop_carts.shop_number', '>', 'numbers.number')*/
            ->get(); //购买数量大于库存量的商品

        $errs = [];
        $sucs = [];
        foreach ($shop_carts as $shop_cart){
            if($shop_cart->shop_number > $shop_cart->number){
                $errs[] = $shop_cart;
            }else{
                if( $shop_cart->is_on_sale = 1){ //二次测试,只将上架的商品存储进去
                    $sucs[] = $shop_cart;
                }
            }
        }
        //如果存在库存不足,将 库存不足的商品信息,进行一个封装
        if($errs){
            $order = new Order();
            //给错误的元素封装属性
            foreach ($errs as &$err){
                $err->attr_values = $order->getAttrValues($err->goods_attribute_ids);
            }
            $errs = $this->getErrMsg($errs);
        }
        return [
            'errs' => $errs,
            'sucs' => $sucs,
        ];
    }

    /**
     * 封装库存量不足的信息
     * @param $errs
     * @return string
     */
    private function getErrMsg($errs)
    {
        $msg = "库存量不足\n";
        foreach ($errs as $err){
            $msg .= str_limit($err->name, 15)." {$err->attr_values} 仅剩 {$err->number}\n";
        }
        return $msg;
    }

    /*public function setGoodsAttributeIdsAttribute($value)
    {
            if(!is_array($value))
                explode(',', $value);
            sort($value, 1); //1代表 SORT_NUMRIC 把每一项当作数字来处理
            $this->attributes['goods_attribute_ids'] = implode(',', $value);;
    }*/

}
