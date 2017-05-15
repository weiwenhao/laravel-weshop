<?php

namespace App\Http\Controllers\Admin;

use App\Models\Goods;
use App\Models\Order;
use App\Models\OrderGoods;
use DB;
use App\Http\Controllers\Controller;

class ComputeController extends Controller
{
    public function compute()
    {
        $day_compute = $this->getDayCompute(); //今天
        $week_compute = $this->getWeekCompute();//本周
        $month_compute = $this->getMonthCompute();//本月
        return view('admin.dash.compute', compact('day_compute', 'week_compute', 'month_compute'));
    }

    private function getDayCompute()
    {
        $start_at = date('Y-m-d', strtotime('-1 day')).' 18:00:00'; //todo 今日订单统计
        $stop_at = date('Y-m-d', time()).' 18:00:00';
        return [
            'start_at' => date('m-d', strtotime('-1 day')).' 18:00',
            'stop_at' => date('m-d', time()).' 18:00',
            'data' =>  $this->shopNumberSum($start_at, $stop_at)
        ];
    }
    private function getMonthCompute()
    {
        $start_at = date('Y-m-01').' 00:00:00'; //todo 月订单统计
        $stop_at = date('Y-m-01', strtotime('+1 month')).' 00:00:00';
        return [
            'start_at' => date('m-01').' 00:00',
            'stop_at' => date('m-01', strtotime('+1 month')).' 00:00',
            'data' =>  $this->shopNumberSum($start_at, $stop_at)
        ];
    }
    private function getWeekCompute()
    {
        $start_at = date('Y-m-d H:i:s', strtotime('sunday -6 day')); //todo 周一,代表星期一   如果查看日期为星期1,则查看到的是上个星期1的数据
        $stop_at = date('Y-m-d H:i:s', strtotime('sunday')); //如果查看日期为星期天,则显示为今天,如果查看日期为星期六则显示为明天的日期
        return [
            'start_at' => date('m-d H:i', strtotime('sunday -6 day')),
            'stop_at' => date('m-d H:i', strtotime('sunday')),
            'data' =>  $this->shopNumberSum($start_at, $stop_at)
        ];
    }

    /**
     * 得到订单的统计信息
     * @param null $start_at 统计开始时间
     * @param null $stop_at 统计结束时间
     * @return mixed 返回一个已分类名称为键值的多维数组
     */
   /* private function shopNumberSum($start_at, $stop_at)
    {
        $where = [];
        if($start_at)
            $where[] = ['orders.created_at', '>', $start_at];
        if($stop_at)
            $where[] = ['orders.created_at', '<', $stop_at];
        $goods = Goods::select('goods.id', 'goods.name', 'categories.name as category_name')
            ->join('categories', 'goods.category_id', '=', 'categories.id')->get();
        $goods= $goods->map(function ($item) use ($where){
            $where[] = ['orders.is_pay', 1];
            $order_goods = OrderGoods::select('order_goods.id', 'orders.created_at as created_at', 'order_goods.shop_number', 'order_goods.shop_price')
                ->where('goods_id', $item->id)
                ->join('orders', 'orders.id', '=', 'order_goods.order_id')
                ->where($where)
                ->get();
            $sum_price = 0;
            $sum_number = 0;
            foreach ($order_goods as $value){
                $sum_number += $value->shop_number;
                $sum_price += $value->shop_number * $value->shop_price;
            }
            $item->sum_price = $sum_price;
            $item->sum_number = $sum_number;
            return $item;
        });
        $goods = $goods->groupBy('category_name');
        return $goods;
    }*/
    private function shopNumberSum($start_at, $stop_at)
    {
        $where = [];
        if($start_at)
            $where[] = ['orders.created_at', '>', $start_at];
        if($stop_at)
            $where[] = ['orders.created_at', '<', $stop_at];
        $goods = Order::select(/*'orders.is_pay', 'orders.created_at', 'order_goods.shop_number',
            'order_goods.shop_price',*/ 'goods.name', 'categories.name as category_name',
                DB::raw('SUM(shop_number) as sum_number'),
                DB::raw('SUM(shop_number*shop_price) as sum_price')
            )
            ->join('order_goods', function ($join) use($where){
                $join->on('orders.id', '=', 'order_goods.order_id')
                ->where($where) //时间限制
                    ->whereNotNull('paid_at'); //必须要为已经支付的商品
            })
            ->rightJoin('goods', 'order_goods.goods_id', '=', 'goods.id')
            ->join('categories', 'categories.id', '=', 'goods.category_id')
            ->orderBy('sum_number', 'desc')
            ->groupBy('goods.id')
            ->get();
        $goods = $goods->groupBy('category_name');
        return $goods;
    }
}
