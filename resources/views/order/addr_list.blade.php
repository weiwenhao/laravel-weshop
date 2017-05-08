@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <!--顶部-->
    <div class="me-header-top">
        <div><a id="previous_page" {{--href="{{ url()->previous() }}--}}><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>请选择</div>
        <div><a href="{{ url('addrs') }}">管理地址</a></div>
    </div>
    <!--收货-->
    <div class="height-2rem"></div>
        @foreach($addrs as $addr)
            <div class="container me-address me-a">
                @if($addr->is_default)
                    <i class="icon icon-moren"><!--默认地址图标--></i>
                @endif
                <a class="address ">
                    <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                    <p>惠州市技师学院,{{ $addr->garden_name }},{{ $addr->floor_name }},{{ $addr->number }}</p>
                </a>
            </div>
        @endforeach
        <div class="center-block" style="display:{{ $addrs->toArray()?'none':'block' }}">
            <span class="fa fa-map-marker fa-5x"></span>
            <h3>你还没有收货地址</h3>
            <p>快去添加一个吧!</p>
            <a href="{{ url('/') }}" class="btn btn-success btn-lg" style=""><i class="fa fa-plus"></i> 添加</a>
        </div>
@stop
@section('js')
    <script>


    </script>
@stop