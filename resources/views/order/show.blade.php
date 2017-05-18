@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>

</style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ url('orders').'?is_pay='.request('is_pay') }}"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>订单详情</div>
        <div></div>
    </div>
    <div class="height-2rem"></div>

    @if($order->paid_at)
        <div class="order-info-status">
            <div class="order-i-s-l ok">付款成功 （〜^㉨^)〜 </div>
            <div class="order-i-s-r"><i class="fa fa-gift fa-4x"></i></div>
        </div>
    @else
        @if($order->orderGoods[0]->status == 3)
            <div class="order-info-status">
                <div class="order-i-s-l ok">订单已关闭</div>
                <div class="order-i-s-r"><i class="fa fa-gift fa-4x"></i></div>
            </div>
        @else
            <div class="order-info-status">
                <div class="order-i-s-l">
                    <p>等待买家付款</p>
                    <p>2小时内自动关闭</p>
                </div>
                <div class="order-i-s-r">
                    <i class="fa fa-credit-card fa-4x"></i>
                </div>
            </div>
        @endif
    @endif
    <!--**********  交易状态  *************-->
    <!--**********  地址  *************-->
    <div class="container me-address">
        <div class="row address">
            <div class="col-xs-1 me-a">
                <i class="fa fa-map-marker fa-lg" style="color: orange"></i>
            </div>
            <div class="col-xs-11" >
                <p>收货人：<b>{{ $order->name }}</b> <tt>{{ $order->phone }}</tt></p>
                <p>惠州市技师学院，{{ $order->floor_name }}，{{ $order->number }}</p>
            </div>
        </div>
    </div>
    <!--全部订单-->
    <!--****************   商品列表 ********************-->
    <div class="container order-list" id="shoppingList">
        <div class="order-item">
            <div class="order-head">
                <span class="success"></span>
            </div>
            <?php $sum_price=0 ?>
            @foreach($order->orderGoods as $item)
                <a href="{{ url('goods').'/'.$item->goods_id }}">
                    <div class="row">
                        <div class="col-xs-3">
                            <img src="{{ $item->sm_image }}" class="img-responsive"/>
                        </div>
                        <div class="col-xs-7">
                            <p>{{ $item->goods_name }}</p>
                            <small>{{ $item->goods_attributes }}</small>
                        </div>
                        <div class="col-xs-2">
                            <div class="pull-right">
                                <span class="">￥{{ $item->shop_price }}</span>
                                <br>
                                <span class="pull-right">
                                 ×{{ $item->shop_number }}
                            </span>
                            </div>
                            @if($item->status == 0)
                                <span class="pull-right" style="color: orange">未处理</span>
                            @elseif($item->status == 1)
                                <span class="pull-right" style="color: #2196f3">已处理</span>
                            @elseif($item->status == 2)
                                <span class="pull-right" style="color: #57bb5b">已完成</span>
                            @elseif($item->status == 3)
                                <span class="pull-right" style="color: red">已关闭</span>
                            @endif
                        </div>
                    </div>
                </a>
                @if(!$loop->last)
                    <hr>
                @endif
                <?php $sum_price += $item->shop_price * $item->shop_number ?>
            @endforeach
            <div class="order-bottom">
                <!--div class="">日期:2017-5-5-</div><hr/-->
                <div class="price">共{{ count($order->orderGoods) }}件商品 合计：<span>{{ $sum_price }}</span></div>
                <hr>
                <div class="price">实付款：<span>￥{{ $order->total_price }}</span></div>
                <!--span class="p3">&nbsp;</span-->
                <!--div class="del">
                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">删除订单</a>
                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">再次购买</a>
                </div-->
            </div>
        </div>
    </div>

    <div class="order-info-number">
        <div class="">订单编号：{{ $order->order_id }} <span class="pull-right " >复制</span></div>
        <div class="">创建时间：{{ $order->created_at }}</div>
        @if($order->paid_at)
            <div class="">付款时间：{{ $order->paid_at }}</div>
        @endif
    </div>

    <div class="height-2rem"></div>
    <!--删除订单 评价 && 取消订单 付款-->
    @if(!$order->paid_at && $order->orderGoods[0]->status !== 3)
        <div class="order-info-bottom">
            <div class="order-i-b-r">
                <a class="me-btn me-a">取消订单</a>
                <a class="me-btn me-a">去付款</a>
            </div>
        </div>
    @endif
@stop
@section('js')
<script>
	
</script>
@stop