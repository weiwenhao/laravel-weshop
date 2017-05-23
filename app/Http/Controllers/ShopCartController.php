<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Number;
use App\Models\Order;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ShopCart $shopCart
     * @return \Illuminate\Http\Response
     */
    public function index(ShopCart $shopCart)
    {
        $shop_carts = $shopCart->getShopCarts();
        return view('shop_cart.list', compact('shop_carts'));
    }


    /**
     * 将商品经过检查过后,加入到购物车中
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ShopCart $shop_cart
     * @param Order $order
     * @return \Illuminate\Http\Response
     * @internal param ShopCart $shopCart
     */
    public function store(Request $request, ShopCart $shop_cart, Order $order)
    {
        $goods_id = $request->get('goods_id');
        $shop_number = $request->get('shop_number');
        $goods_attribute_ids = sortOrImplode($request->get('goods_attribute_ids', [])); // 返回一个排序过的字符串
        //商品检查
        if($err_msg = $order->checkOneGoods($goods_id, $goods_attribute_ids, $shop_number)){
            return response($err_msg, 422);
        }
        //存取
        $res = $shop_cart->storeShopCart($goods_id, $goods_attribute_ids, $shop_number);
        return $res;
    }

    /**
     * 批量修改库存量
     * @param Request $request
     * @return void
     */
    public function editShopNumbers(Request $request){
        $shop_numbers = $request->get('shop_numbers', []);
        foreach ($shop_numbers as $shop_number){
            ShopCart::where('id', $shop_number['id'])->where('user_id', \Auth::user()->id)->update([
                'shop_number' => $shop_number['shop_number']
            ]);
        }
    }

    public function delShopCarts(Request $request)
    {
        $shop_cart_ids = $request->get('shop_cart_ids');
        foreach ($shop_cart_ids as $shop_cart_id){
            ShopCart::where('id', $shop_cart_id)->where('user_id', \Auth::user()->id)->delete();
        }
    }



}
