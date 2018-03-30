@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
    <style>
    </style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ request()->cookie('orders_exit_url')?:url('me') }}"><span class="icon icon-back icon-lg"></span></a></div>
        <div>我的订单</div>
        <div></div>
    </div>
    <div class="height-2rem"></div>
    <!--**********   个人 *************-->
    <div class="me-order-top">
        <div class="order-item">
            <a  href="{{ url('orders') }}" >全部</a>
        </div>
        <div class="order-item">
            <a href="{{ url('orders') }}?is_pay=0" >待付款</a>
        </div>
        <div class="order-item">
            <a href="{{ url('orders') }}?is_pay=1" >已支付</a>
        </div>
        <div class="order-item">
            <a href="{{ url('orders/no_comment') }}" class="active">待评价</a>
        </div>
    </div>

    <!--全部订单-->
    <!--****************   商品列表 ********************-->
    <div class="container order-list" id="shoppingList">
        @foreach($order_goods as $item)
            {{--根据url判断,如果显示的内容是待付款的订单 然后 判断订单中的第一件商品的状态是否为3(已关闭),如果是的话,则跳过该循环--}}
            @continue(request('is_pay') === '0' && $order->orderGoods[0]->status == 3)
            <div class="order-item">
                <div class="order-head">
                    <span>
                        付款时间：{{ $item->paid_at }}
                    </span>
                </div>
                <a href="#">
                    <div class="row">
                        <div class="col-xs-3">
                            <img src="{{ $item->sm_image }}" class="img-responsive"/>
                        </div>
                        <div class="col-xs-7">
                            <p>{{ $item->goods_name }}</p>
                            <small>{{ $item->goods_attributes }}</small>
                        </div>
                        <div class="col-xs-2">
                            <div class=" pull-right">
                                <span class="">￥{{ $item->shop_price }}</span>
                                <br>
                                <span class="pull-right">×{{ $item->shop_number }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="order-bottom">
                        <div class="price"></div><hr/>
                        <span class="p3">&nbsp;</span>
                        <div class="del" style="line-height: 0.1rem">
                            <a href="{{ url('goods_comments/create/'.$item->id) }}" class="weui-btn weui-btn_mini btn-orange-c">去评价</a>
                        </div>
                </div>
            </div>
        @endforeach
        <div class="weshop-center-block" style="display:{{ count($order_goods->toArray()) > 0?'none':'block' }};">
            <i class="icon icon-dingdan"></i>
            <h3>您还没有相关订单</h3>
            <p>可以去看看有哪些想买的</p>
        </div>
    </div>
@stop
@section('js')
@stop