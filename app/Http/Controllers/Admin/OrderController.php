<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Http\Controllers\Controller;
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
        return view('admin.order.list');
    }

    public function dtData()
    {
        $where = [];
        if(\request('is_pay') !== null){
            $where[] = ['is_pay', \request('is_pay')];
        }
        if(\request('status') !== null){
            $where[] = ['status', \request('status')];
        }
        return Datatables::of(Order::where($where))
            ->addColumn('self_info', function (Order $order){
            //通过admin,处理出一段希望展示出来的roles字段,以行为单位
                return "$order->name<br/>$order->phone<br>$order->garden_name $order->floor_name $order->number";
            })
            ->addColumn('order_content', function (Order $order){
                return $order->orderContent();
            })->rawColumns(['self_info','order_content'])->make(true);
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
        $order_ids = request('order_ids');
        $status = request('status');
        $res = Order::whereIn('id', $order_ids)->update([
            'status' => $status
        ]);
        return $res; //受影响的记录数
    }
}
