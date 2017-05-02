@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food.css"/>
<style>

</style>
@stop
@section('content')
    <!--**************** 顶部 ********************-->
    <div class="me-header-top">
        <div><a href="{{ url()->previous() }}"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>详情</div>
        <div></div>
    </div>
    <!--**************** 详情 ********************-->
    <div class="goods-info-img">
        <img class="img-rounded" src="{{ $goods->big_image }}" />
    </div>
    <div class="goods-info-img-empty" id="showAndroidActionSheet"></div>
    <div class="goods-info">
        <div class="goods-list goods-info-name"><p>{{ $goods->name }}</p></div>
       {{-- <div class="goods-list">
            <p><!--星星-->
                <span class="fa fa-star "></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star-half-o"></span>
                <span class="fa fa-star-o "></span>
            </p>
        </div>--}}
        <div class="goods-list goods-info-price">
            <span>￥{{ $goods->price }} </span>{{--<del> ￥2099</del>--}}
            <small><i class="fa fa-line-chart"></i> 销量：{{ $goods->buy_count }}</small>
        </div>
        <div class="goods-list weui-cell">
            <div class="weui-cell__hd">
            </div>
            <div class="weui-cell__bd">
            </div>
            <div class="weui-cell__ft"></div>
        </div>
        @if($goods->description)
            <div class="goods-list ">商品详情</div>
            <div class="goods-list goods-info-txt">
                {!! $goods->description !!}
            </div>
        @endif
    </div>
    <!--点击图片查看大图-->
    <div class="page actionsheet">
        <div class="weui-skin_android" id="androidActionsheet" style="display:none">
            <div class="weui-mask"></div>
            <div class="weui-actionsheet">
                <img src="{{ $goods->big_image }}" />
                <span class="fa fa-times-circle-o fa-2x" id="outImg"></span>
            </div>
        </div>
    </div>
    <!--**************** 加入购物车 立即购买 ********************-->
    <div calss="container" id="bill">
        <div class="row" style="bottom:0;">
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <a class="weui-btn weui-btn_warn" id="addShopCart" style="background:#f90">加入购物车</a>
            </div>
            <div class="col-xs-4">
                <a class="weui-btn weui-btn_warn" >立即购买</a>
            </div>
        </div>
    </div>
    <!--*************** 弹出菜单 ********************-->
@stop
@section('js')
    <script type="text/javascript" src="/js/food.js"></script>
<script>
	//加入购物车操作
    $('#addShopCart').click(function () {
        //ajax请求
        //todo, 如果商品有属性应该先判断是否选择了商品属性
       addShopCart({{ $goods->id }});
    });
</script>
@stop