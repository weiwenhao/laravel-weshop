<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Number;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ShopCart $shop_cart
     * @return \Illuminate\Http\Response
     * @internal param ShopCart $shopCart
     */
    public function store(Request $request, ShopCart $shop_cart)
    {
        $goods_id = $request->get('goods_id');
        $shop_number = $request->get('shop_number');
        $goods_attribute_ids = sortOrImplode($request->get('goods_attribute_ids', []));

        if(!Goods::find($request->get('goods_id'))){
            return response('系统错误', 404);
        }
        //检查库存
        if(!Number::checkNumber($goods_id, $goods_attribute_ids, $shop_number)){
            return response('库存量不足', config('shop.no_number'));
        }
        //存取
        $res = $shop_cart->storeShopCart($goods_id, $goods_attribute_ids, $shop_number);
        return $res;
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
