<?php

namespace App\Http\Controllers;

use App\Models\Addr;
use App\Models\Number;
use App\Models\Order;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 得到该用户的地址列表
     */
    public function addrs()
    {
        $addrs = Addr::where('user_id', \Auth::user()->id)->get();
        return view('order.addr_list', compact('addrs'));
    }

    /**
     * 确认订单列表
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Order $order)
    {
        //取出地址数据
        $addr = '';
        if(session('order_addr_id')){
            $addr = Order::find(session('order_addr_id'));
        }
        //取出商品数据
        $goods = $order->getSessionOrderGoods();
        //补充商品属性信息
        return view('/order/confirm', compact('addr', 'goods'));
    }

    /**
     * 确认订单存储
     * @param Request $request
     * @param ShopCart $shopCart
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function confirmStore(Request $request, ShopCart $shopCart)
    {
        $shop_cart_ids = $request->get('shop_cart_ids');
        //库存手动验证
        $data = $shopCart->checkShopCarts($shop_cart_ids);
        if($data['errs']){
            return response($data['errs'], config('shop.no_number'));
        }
        //存储addr_id
        $addr = Addr::where([
            'user_id' => \Auth::user()->id,
            'is_default' => 1,
        ])->first();
        $order_addr_id = '';
        if($addr){
            $order_addr_id = $addr->id;
        }
        //生成临时订单session数据
        $order_goods = json_encode($data['sucs']);
        //sesssion存储
        session(['order_addr_id' => $order_addr_id]);
        session(['order_goods' => $order_goods]);
        //跳转到确认订单页
        return response('验证通过', 200);
    }

}
