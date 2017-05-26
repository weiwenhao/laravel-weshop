<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    //
    protected $guarded = [];
    protected $table = 'order_goods';

    public function getNoCommentGoods()
    {
        $data = $this->select('orders.paid_at', 'order_goods.*')
                ->join('orders', 'orders.id', '=', 'order_goods.order_id')
                ->where('orders.user_id', \Auth::user()->id)
                ->where('order_goods.status', '=', 2) //2代表已完成
                ->where('order_goods.is_comment', '=', 0)
                ->get();
        return $data;
    }

}
