@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/shopping_car.css"/>
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ url()->previous() }}"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>确认订单</div>
        <div></div>
    </div>
    <!--收货-->
    <div class="height-2rem"></div>
    <div class="container me-address me-a">
        @if($addr)
            <a href="{{ url('orders/addrs') }}">
                <div class="row address">
                    <div class="col-xs-1">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="col-xs-10">
                        <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                        <p>惠州市技师学院,{{ $addr->garden_name }},{{ $addr->floor_name }},{{ $addr->number }}</p>
                    </div>
                    <div class="col-xs-1">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
            </a>
        @else
            <a  href="{{ url('orders/addrs') }}">
                <div class="row address">
                    <div class="col-xs-11 text-center">
                        <div class="me-font-f90 address-new"><i class="fa fa-map-marker me-font-f90"></i>  点击选择收货地址</div>
                    </div>
                    <div class="col-xs-1">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
            </a>
        @endif
    </div>

    <!--****************   商品列表 ********************-->
    <div class="container" id="shoppingList" >
        <?php  $sum_price=0;?>
        @foreach($goods as $item)
            <div class="row">
                <div class="col-xs-3">
                    <img src="{{ $item->sm_image }}" class="img-responsive"/>
                </div>
                <div class="col-xs-7">
                    <p>{{ $item->name }}</p>
                    <small>{{ $item->attr_name_values }}</small>
                </div>
                <div class="col-xs-2">
                    <div class="RMBnum"></i><span class="price-decimal-point">{{ $item->shop_price }}</span><br>x<tt>{{ $item->shop_number }}</tt></div>
                </div>
            </div>
            <?php $sum_price+= $item->shop_price*$item->shop_number?>
        @endforeach

    </div>
    <!---->
    <a class="weui-cell weui-cell_access me-fff" >
        <div class="weui-cell__bd">
            支付方式
        </div>
        <div class="weui-cell__ft">微信支付</div>
    </a>
    <a class="weui-cell weui-cell_access me-fff" >
        <div class="weui-cell__bd">
            配送费
        </div>
        <div class="weui-cell__ft">￥0.00</div>
    </a>
    <div class="weui-cell me-fff">
        <div class="weui-cell__hd">订单备注：</div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="订单要求信息">
        </div>
    </div>
    <!--****************结算********************-->
    <div calss="container" id="bill">
        <div class="row">
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4">
                <span>合计:￥<tt>{{ $sum_price }}</tt></span>
            </div>
            <div class="col-xs-4" name="">
                <a href="select_address.html" class="weui-btn weui-btn_warn" id="sub" >提交订单</a>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>


    </script>
@stop