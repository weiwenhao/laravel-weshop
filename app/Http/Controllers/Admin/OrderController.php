<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderGoods;
use Yajra\Datatables\Facades\Datatables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::select('name', 'id')->get();
        return view('admin.order.list', compact('categories'));
    }

    public function dtData()
    {
//        dd(request()->all());
        $where = [];
        if(\request('is_pay') === '1'){ //处理通过.
            //直接进行一个query的得到?
            $query = Order::whereNotNull('paid_at');
        }elseif(\request('is_pay') === '0'){
            $query = Order::whereNull('paid_at');
        }elseif(\request('is_pay') === null){
            $query = Order::query();
        }

        if(\request('status') !== null){
            $where[] = ['status', \request('status')];
        }
        if(\request('floor_name') !== null){
            $where[] = ['floor_name', \request('floor_name')];
        }
        if(\request('category_id') !== null){
            $where[] = ['category_id', \request('category_id')];
        }

        $query = $query->select('orders.*', 'goods.id as goods_id', 'goods.name as goods_name', 'goods.category_id',
            'order_goods.goods_attribute_ids', 'order_goods.shop_price', 'order_goods.shop_number', 'order_goods.status', 'order_goods.id as order_goods_id') //order_goods_id
            ->join('order_goods', 'order_goods.order_id', '=', 'orders.id')
            ->join('goods', 'order_goods.goods_id', '=', 'goods.id')
            ->where($where);

        return Datatables::of($query)
            ->addColumn('self_info', function (Order $order){
            //通过admin,处理出一段希望展示出来的roles字段,以行为单位
                return "$order->name<br/>$order->phone<br> $order->floor_name $order->number";
            })
            ->addColumn('order_content', function (Order $order){
                return $order->orderContent();
            })->rawColumns(['self_info','order_content'])
           /* ->addColumn('action', 'admin.order.dt_buttons')*/
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

    public function handleOrder(){
        $order_goods_ids = request('order_goods_ids');
        $status = request('status');
        $res = OrderGoods::whereIn('id', $order_goods_ids)->update([
            'status' => $status
        ]);
        return $res; //受影响的记录数
    }
}
