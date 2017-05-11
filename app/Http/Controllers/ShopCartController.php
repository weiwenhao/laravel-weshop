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
        //session记录一下当前url方便存储 todo 待重构为cookie,或者中间件
        session(['confirm_previous_url' => \request()->getUri()]);

        $shop_carts = $shopCart->getShopCarts();
        return view('shop_cart.list', compact('shop_carts'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ShopCart $shop_cart
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
