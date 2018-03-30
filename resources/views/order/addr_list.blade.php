@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <!--顶部-->
    <div class="me-header-top">
        <div><a href="{{ url('orders/confirm') }}"><span class="icon icon-back icon-lg"></span></a></div>
        <div>请选择</div>
        <div><a href="{{ url('addrs') }}">管理 <i class="icon icon-location"></i></a></div>
    </div>
    <!--收货-->
    <div class="height-2rem"></div>
        @foreach($addrs as $addr)
            <form id="set-addr-{{ $addr->id }}" action="{{ url('/orders/confirm/addrs/'.$addr->id) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <div class="container me-address me-a"
                 onclick="event.preventDefault();document.getElementById('set-addr-{{ $addr->id }}').submit();">
                    @if($addr->is_default)
                        <i class="icon icon-moren"><!--默认地址图标--></i>
                    @endif
                    <a class="address ">
                        <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                        <p>惠州市技师学院，{{ $addr->floor_name }}，{{ $addr->number }}</p>
                    </a>
                </div>
        @endforeach
        <div class="weshop-center-block" style="display:{{ $addrs->toArray()?'none':'block' }}">
            <i class="icon icon-locationfill"></i>
            <div class="title">你还没有收货地址</div>
            <div>快去添加一个吧!</div>
            <a href="{{ url('addrs/create') }}" class="weui-btn  weui-btn_primary" style="">添加</a>
        </div>
@stop
@section('js')
    <script>


    </script>
@stop