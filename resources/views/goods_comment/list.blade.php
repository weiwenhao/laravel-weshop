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
            <div><a href="{{ url('goods/'.$goods_id) }}"><span class="icon icon-back icon-lg"></span></a></div>
            <div class="food-info-nav">
                <a href="{{ url('goods/'.$goods_id) }}">商品</a>
                <a href="{{ url('goods/'.$goods_id.'/desc') }}">详情</a>
                <a href="" class="active">评价</a>
            </div>
            <div>{{--<a href="{{ url('shop_carts') }}"><span class="icon icon-cart icon-lg"></span></a>--}}</div>
        </div>
        <!--**************** 详情 ********************-->
        <div style="height:2rem;"></div>
        <goods-comments goods_id="{{ $goods_id }}"></goods-comments>
    </div>
@stop
@section('js')
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
        const app = new Vue({
            el: '#goods-comment',
        });
    </script>
@stop