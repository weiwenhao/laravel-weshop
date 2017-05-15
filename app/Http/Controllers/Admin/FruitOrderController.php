<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class FruitOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fruit_order.list');
    }
    public function dtData()
    {
        /**
         * 首先要展示信息 (不考虑筛选),只显示已经支付了的 但是订单状态筛选依旧需要加上,不需要排序了吧
        170502092133
        魏文豪
        13168065609
        积善园 孝悌楼 503
        红烧鸡排 x2 单价:99.99
        操作系统：ios
        */
        $where = [];
        if(\request('status') !== null){
            $where[] = ['status', \request('status')];
        }
        if(\request('floor_name') !== null){
            $where[] = ['floor_name', \request('floor_name')];
        }


        $query = Order::select('orders.*', 'goods.id as goods_id', 'goods.name as goods_name', 'goods.category_id',
            'order_goods.goods_attribute_ids', 'order_goods.shop_price', 'order_goods.shop_number', 'order_goods.status', 'order_goods.id as order_goods_id') //order_goods_id
        ->join('order_goods', 'order_goods.order_id', '=', 'orders.id')
            ->join('goods', 'order_goods.goods_id', '=', 'goods.id')
            ->where($where)->where([
                ['category_id', 2], //2代表水果订单id
            ])
            ->whereNotNull('paid_at'); //已经支付过的订单

        return Datatables::of($query)
            ->addColumn('all_info', function (Order $order){
                $res = "$order->name $order->floor_name $order->number<br/>$order->phone";
                $res .= "<br>";
                $res .= $order->orderContent();
                return $res;
            })->rawColumns(['all_info', 'action'])
             ->addColumn('action', 'admin.fruit_order.action')
            ->make(true);
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
}
