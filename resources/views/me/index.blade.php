@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>

</style>
@stop
@section('content')
    {{--<div class="me-header-top" style="position: static;z-index: 1000">
        <div></div>
        <div></div>
        <div><span class="icon icon-message icon-lg"></span></div>
    </div>--}}
    {{--<div class="height-2rem"></div>--}}
    <!--**********   个人 *************-->
    {{--<div class="me-info center-block" >
        <img class="img-circle img-thumbnail" src="{{ Auth::user()->logo }}">
        <div class="me-name"><h5>{{ Auth::user()->username }}</h5></div>
    </div>--}}
    <div class="btn-orange-c me-info-back ">
        <div class="round r-1"></div>
        <div class="round r-2"></div>
        <div class="round r-3"></div>
        <div class="round r-4"></div>
        <div class="round r-5"></div>
        <div class="me-info center-block " >
            <img class="img-circle img-thumbnail" src="{{ Auth::user()->logo }}">
            <div class="me-name">{{ Auth::user()->username }}</div>
        </div>
    </div>
    <!--**********   余额，优惠，积分 *************-->
    <div class="weui-grids">
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="icon icon-footprint icon-2rem"></span>
            </div>
            <p class="weui-grid__label">足迹</p>
        </a>
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="icon icon-ticket icon-2rem"></span>
            </div>
            <p class="weui-grid__label">优惠券</p>
        </a>
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="icon icon-refund icon-2rem"></span>
            </div>
            <p class="weui-grid__label">积分</p>
        </a>
    </div>

    <!--**********  带图标、说明、跳转的列表项 *************-->
    <div class="weui-cells me-list">
        <a class="weui-cell weui-cell_access" href="{{ url('orders') }}">
            <div class="weui-cell__hd"><span class="icon icon-dingdan"></span></div>
            <div class="weui-cell__bd">
                <p>我的订单</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="{{ url('collects') }}">
            <div class="weui-cell__hd"><span class="icon icon-favor"></span></div>
            <div class="weui-cell__bd">
                <p>我的收藏</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="{{ url('addrs') }}">
            <div class="weui-cell__hd"><span class="icon icon-location"></span></div>
            <div class="weui-cell__bd">
                <p>收货地址</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:void(0);">
            <div class="weui-cell__hd"><span class="icon icon-edit"></span></div>
            <div class="weui-cell__bd">
                <p>意见反馈</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
    @include('layouts.your_like')
    @include('layouts.bottom_nav')
@stop
@section('js')
<script>
	
</script>
@stop