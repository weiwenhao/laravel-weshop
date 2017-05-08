@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <!--顶部-->
    <div class="me-header-top">
        <div><a id="previous_page"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>我的收货地址</div>
        <div></div>
    </div>
    <!--收货地址-->
    <div class="height-2rem"></div>
    @foreach($addrs as $addr)
        <div class="container me-address">
            <div class="row address">
                @if($addr->is_default)
                    <i class="icon icon-moren"><!--默认地址图标--></i>
                @endif
                <div class="col-xs-1 me-a showIOSDialog1">
                    <i class="fa fa-times-circle-o fa-lg"></i>
                </div>
                <div class="col-xs-10 " >
                    <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                    <p>惠州市技师学院,{{ $addr->garden_name }},{{ $addr->floor_name }},{{ $addr->number }}</p>
                </div>
                <div class="col-xs-1 me-a" name="addressGo">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
        </div>
    @endforeach
    <div class="center-block" style="display:{{ $addrs->toArray()?'none':'block' }}">
        <span class="fa fa-map-marker fa-5x"></span>
        <h3>╮(￣▽￣")╭</h3>
    </div>

    <a class="weui-btn weui-btn_primary new-address"  href="{{ url('addrs/create') }}">新增收货地址</a>
@stop
@section('js')
    <script type="text/javascript" src="/js/shopping_car.js"></script>
    <script>

    </script>
@stop