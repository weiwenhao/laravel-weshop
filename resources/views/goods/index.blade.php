@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/plugins/swiper/swiper.min.css"/> <!--轮播-->
    {{--<link rel="stylesheet" href="/css/home.css"/> --}}{{--首页css--}}
    <style id="frames"></style>
<style>
</style>
@stop
@section('content')
    <!--**************** 搜索 ********************-->
    <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" method="get" action="{{ url('goods') }}">
            <div class="weui-search-bar__box">
                <i class="weui-icon-search"></i>
                <input type="search" name="key" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required="">
                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
            </div>
            <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                <i class="weui-icon-search"></i>
                <span>搜索</span>
            </label>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
    </div>
    <!--**************** 轮播 ********************-->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($actives as $active)
                <div class="swiper-slide">
                    <a href="{{ $active->is_content?'/actives/'.$active->id:'#' }}">
                        <img class="img-responsive" src="{{ $active->image }}" />
                    </a>
                </div>
            @endforeach
                <div class="swiper-pagination"><!-- 分页器 --></div>
        </div>
        <div class="swiper-pagination"><!-- 分页器 --></div>
    </div>
    <div class="font-move">
        <span>公告:天呐 天呐 天哪来啦 （〜^㉨^)〜</span>
    </div>
    <!--**************** 九宫格 ********************-->
    <div class="weui-grids" style="background:#fff">
        <!-- 第一个宫格 -->
        <a href="/goods?category_id=1" class="weui-grid">
            <!-- 图标 -->
            <div class="weui-grid__icon">
                <img src="/images/icon1.png" alt="">
            </div>
            <!-- 标签文字 -->
            <div class="weui-grid__label">校园外卖</div>
        </a>
        <a href="/goods?category_id=2" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="/images/icon2.png" alt="">
            </div>
            <div class="weui-grid__label">水果超市</div>
        </a>
        <a href="{{ url('goods/categories') }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="/images/icon3.png" alt="">
            </div>
            <div class="weui-grid__label">商品分类</div>
        </a>
        <a href="{{ url('posts') }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="/images/icon4.png" alt="">
            </div>
            <div class="weui-grid__label">校园圈子</div>
        </a>

        <a href="#" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="/images/icon5.png" alt="">
            </div>
            <div class="weui-grid__label">消息中心</div>
        </a>
        <a href="{{ url('orders') }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="/images/icon6.png" alt="">
            </div>
            <div class="weui-grid__label">订单管理</div>
        </a>
    </div>
    <!-- 商品列表-->
    <div class="weui-cell me-font-f90">
        <div class="weui-cell__bd">
            <span><i class="icon icon-likefill"></i> 精品推荐</span>
        </div>
        <div class="weui-cell__ft"></div>
    </div>

    <div class="me-goods-List">
        @foreach($best_goods as $goods)
            <div class="shopp-item">
                <a class="me-on-a me-a"  href="{{ url('/goods/'.$goods->id) }}">
                    <!--添加name='off'出现下架-->
                    <img class="img-responsive {{ $goods->is_sale?'':"off-sale" }}" data-img="{{ $goods->mid_image }}"/>
                    <p>{{ $goods->name }}</p>
                </a>
                <p>
                    <span class="price-decimal-point">{{ $goods->price }}</span>
                    <small>销量:{{ $goods->buy_count }}</small>
                    <a class="icon icon-favor collect" goods_id="{{ $goods->id }}"></a>
                </p>
            </div>
        @endforeach
    </div>
    <!--**********   底部导航  **************-->
    @include('layouts.bottom_nav')
@stop
@section('js')
    <script src="/plugins/swiper/swiper.min.js">/*这是轮播框架*/</script>
    <script src="/js/home.js"></script>
<script>
    weui.searchBar('#searchBar'); //搜索框
</script>
@stop
