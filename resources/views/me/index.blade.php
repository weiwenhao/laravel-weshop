@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>

</style>
@stop
@section('content')
    <div class="me-header-top">
        <div></div>
        <div>个人中心</div>
        <div><span class="fa fa-bell fa-lg"></span></div>
    </div>
    <div class="height-4rem"></div>
    <!--**********   个人 *************-->
    <div class="me-info center-block" >
        <img class="img-circle img-thumbnail" src="{{ Auth::user()->logo }}">
        <div class="me-name"><h5>{{ Auth::user()->username }}</h5></div>
    </div>
    <!--**********   余额，优惠，积分 *************-->
    <div class="weui-grids">
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="fa fa-circle-o fa-2x "></span>
            </div>
            <p class="weui-grid__label">足迹</p>
        </a>
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="fa fa-money fa-2x "></span>
            </div>
            <p class="weui-grid__label">优惠券</p>
        </a>
        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <span class="fa fa-database fa-2x "></span>
            </div>
            <p class="weui-grid__label">积分</p>
        </a>
    </div>

    <!--**********  带图标、说明、跳转的列表项 *************-->
    <div class="weui-cells me-list">
        <a class="weui-cell weui-cell_access" href="{{ url('orders') }}">
            <div class="weui-cell__hd"><span class="fa fa-lemon-o"></span></div>
            <div class="weui-cell__bd">
                <p>我的订单</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="{{ url('collects') }}">
            <div class="weui-cell__hd"><span class=" fa fa-heart"></span></div>
            <div class="weui-cell__bd">
                <p>我的收藏</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="{{ url('addrs') }}">
            <div class="weui-cell__hd"><span class="fa fa-map-marker"></span></div>
            <div class="weui-cell__bd">
                <p>收货地址</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:void(0);">
            <div class="weui-cell__hd"><span class="fa fa-volume-control-phone"></span></div>
            <div class="weui-cell__bd">
                <p>意见反馈</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
    @include('layouts.bottom_nav')
@stop
@section('js')
<script>
	
</script>
@stop