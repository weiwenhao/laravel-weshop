@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food_info.css"/>
    <style>

    </style>
@stop
@section('content')
    <div id="goods-comment">
        <!--**************** 顶部 ********************-->
        <div class="me-header-top me-header-food-info"><!--m-->
            <div><a href="{{ url('goods/'.$goods->id) }}"><span class="icon icon-back icon-lg"></span></a></div>
            <div class="food-info-nav">
                <a href="{{ url('goods/'.$goods->id) }}">商品</a>
                <a href="#" class="active">详情</a>
                <a href="{{ url('goods_comments/'.$goods->id) }}">评价</a>
            </div>
            <div>{{--<a href="{{ url('shop_carts') }}"><span class="icon icon-cart icon-lg"></span></a>--}}</div>
        </div>
        <div style="height:2rem;"></div>
        <!--**************** 详情 ********************-->
        <div class="goods-list goods-info-txt">
            {!! $goods->description !!}
        </div>

        <div class="weshop-center-block" style="display:{{ $goods->description?'none':'block' }}">
            <i class="icon icon-text" style=""></i>
            <div class="title">暂时没有商品详情~</div>
        </div>
    </div>
@stop
@section('js')
    @if($goods)
        <script>

            //去掉商品详情中图片的style的高,和宽100%
            $('.goods-info-txt').find('img').css('height', 'auto');
            $('.goods-info-txt').find('img').css('width', '100%');
        </script>
    @endif
@stop