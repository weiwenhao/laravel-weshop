<?php

namespace App\Http\Controllers;

use App\Models\Addr;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\ShopCart;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $where = [];
        //进行status的判断来进行显示.  已关闭 = 全部?
        $is_pay = \request('is_pay');
        if($is_pay === '1'){
            $query = Order::whereNotNull('paid_at');
        }elseif($is_pay === '0'){
            $query = Order::whereNull('paid_at');
        }else{
            $query = Order::query();
        }
        //待付款订单只显示 未关闭且未付款
        $orders = $query->with('orderGoods')->where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get(); //with一个orderGoods
        return view('order.list', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        return view('order.show', compact('order'));
    }
    public function store(Request $request, ShopCart $shopCart, Order $order, Application $wechat)
    {
      /* return response()->json([
            'order_id' => 1,
            'config' => json_decode('{
           "appId":"wx2421b1c4370ec43b",
           "timeStamp":"1395712654", 
           "nonceStr":"e61463f8efa94090b1f366cccfbbb444",  
           "package":"prepay_id=u802345jgfjsdfgsdg888",     
           "signType":"MD5",   
           "paySign":"70EA570631E4BB79628FBCA90534C63FF7FADD89"
        }'),
        ]);*/

        //confirm中的商品检测-> 如果confirm中存在shop_cart_id,其实就是根据shop_cart_id再进行一次购物车检测
        $order_goods = json_decode(session('order_goods'));
        $shop_cart_ids = [];
        foreach ($order_goods as $item) {
            $shop_cart_ids[] = $item->id;
        }
        $err_msgs = $shopCart->checkShopCarts($shop_cart_ids);
        if($err_msgs){
            return response($err_msgs, 422);
        }
        //地址也进行一个检测
        $addr = Addr::where('id', session('order_addr_id'))->where('user_id', \Auth::user()->id)->first();
        if(!$addr){
            return response('请选择收货地址', 422);
        }
        //生成订单模型
        $order = $order->shopCartsToOrders($order_goods, $addr);
        if(!$order->id){
            return response('系统错误,请联系客服', 500);
        }

        $perpay_id = $order->getPrepayId();
        if(!$perpay_id){
            return response('系统错误,请联系客服', 500);
        }
        $payment = $wechat->payment;
        $config = $payment->configForPayment($perpay_id, false); //第二个参数为false表示生成数组形式
        return response()->json([
            'order_id' => $order->id,
            'config' => $config,
        ]);

    }

    public function destroy($id)
    {
        //能不能在该用户名下查找到该订单
        $order = Order::where('id', $id)->where('user_id', \Auth::user()->id)->first();
        if(!$order || $order->paid_at){ //订单不存在, 或者 订单存在但是已经支付
            return response('403', '系统错误，请联系客服');
        }
        foreach ($order->orderGoods as $key => $item){
            //将该订单下的商品的status都设置为 3
            $order->orderGoods[$key]->status = 3;
            //save保存一下
            $order->orderGoods[$key]->save();
        }
        return response('订单已经关闭', 200);
    }

    public function repay(Application $wechat)
    {
        $order_id = \request()->get('order_id');
        $order = Order::where('id', $order_id)->where('user_id', \Auth::user()->id)->first();
        if(!$order){
            return response('订单不存在', 404);
        }
        //商品再次验证,使用checkOneGoods
        foreach ($order->OrderGoods as $item) {
            $err_msg = $order->checkOneGoods($item->goods_id, $item->goods_attribute_ids, $item->shop_number);
            if($err_msg){
                return response('订单中存在下架商品，请重新下单', 422);
            }
            //重新计算一下价格
            if($item->shop_price != $order->getShopPrice($item->goods_id, $item->goods_attribute_ids)){
                return response('商品存在价格变动，请从新下单', 422);
            }
        }
        //重新申请下单
        $perpay_id = $order->getPrepayId();
        $payment = $wechat->payment;
        $config = $payment->configForPayment($perpay_id, false); //第二个参数为false表示生成数组形式
        return response()->json([
            'order_id' => $order->id,
            'config' => $config,
        ]);

    }
    /**
     * 得到该用户的地址列表,提供给用户在设置订单的时候方便的选择收获地址
     */
    public function addrs()
    {
        //todo  考虑加cookie中记录当前url, 以便进行返回. cookie不会使用,暂时使用session先
//        dd($this->getRedirectUrl());得到上一页的url地址
        session(['addrs_previous_url' => \request()->getUri()]);

        $addrs = Addr::where('user_id', \Auth::user()->id)->get();
        return view('order.addr_list', compact('addrs'));
    }

    public function setAddrId($addr_id)
    {
        //检验该id的有效性
        $addr = Addr::where('id', $addr_id)->where('user_id', \Auth::user()->id)->firstOrFail();
        //设置该id到session中
        session(['order_addr_id' => $addr->id]);
        return redirect('orders/confirm');
    }

    /**
     * 确认订单列表
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Order $order)
    {
        //取出地址数据
        $addr = Addr::where('id', session('order_addr_id', ''))->where('user_id', \Auth::user()->id)->first();
        //取出商品数据
        $goods = $order->getSessionOrderGoods();
        //补充商品属性信息
        return view('/order/confirm', compact('addr', 'goods'));
    }

    /**
     * 购物车总店结算操作进行勾选商品的验证和存储
     * @param Request $request
     * @param ShopCart $shopCart
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function confirmStore(Request $request, ShopCart $shopCart)
    {
        $shop_cart_ids = $request->get('shop_cart_ids'); // [1, 2, 5, 3] 无序的数组形式
        $shop_numbers = $request->get('shop_numbers');
        //计算几下数量是否对应,不对应则返回null , 这样都要刷库,太费资源
        foreach ($shop_cart_ids as $key => $shop_cart_id){
            if($shop_numbers[$key]){
                ShopCart::where('id', $shop_cart_id)->where('user_id', \Auth::user()->id)->update(['shop_number'=> $shop_numbers[$key]]);
            }
        }
        //考虑根据ajax获得以下勾选的库存量,然后进行一个购物车数据的修改
        //库存手动验证
        $err_msgs = $shopCart->checkShopCarts($shop_cart_ids);
        if($err_msgs){
            return response($err_msgs, 422);
        }
        //存储购物车中
        $shopCart->shopCartsToSession($shop_cart_ids);

        //跳转到确认订单页
        return response('验证通过', 200);
    }

    /**
     * 接收微信支付的结果, 并做相应的处理
     * @param Application $wechat
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notify(Application $wechat)
    {
       $response = $wechat->payment->handleNotify(function($notify, $successful){
           // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
           $order = Order::where('order_id', $notify->out_trade_no)->first();
           if (!$order) { // 如果订单不存在
               return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了 ,这是返回具体的错误信息,相当于返回 return false //表示已经处理完成
           }
           // 如果订单存在
           // 检查订单是否已经更新过支付状态
           if ($order->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
               return true; // 已经支付成功了就不再更新了
           }
           // 用户是否支付成功
           if ($successful) {
               //将支付时间更新为当前时间
               $order->paid_at = time(); // 更新支付时间为当前时间
           } /*else { // 用户支付失败
               $order->status = 'paid_fail';
           }*/
           $order->save(); // 保存订单
           return true; // 返回处理完成
       });
       return $response;
    }

}
