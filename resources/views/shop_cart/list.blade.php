@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/shopping_car.css"/>
    <style>

    </style>
@stop
@section('content')
    <style type="text/css">
    </style>
    <div class="me-header-top">
        <div><a id="historyPageGo"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>购物车</div>
        <div><a id="me_edit">编辑全部</a></div>
    </div>
    <!--****************   购物车列表.2.0 ********************-->
    <div class="height-2rem"></div>
    <div class="container shopping-hoem" id="shoppingList">
        @foreach($shop_carts as $shop_cart)
            <div class="row">
                <!--添加name='off'出现下架-->
                <div class="col-xs-1"><!--选项-->
                    <label for='{{ $loop->index }}' class="me-checkbox-icon">
                        <input id="{{ $loop->index }}" type="checkbox" name="select" value="1"/>
                        <i class="weui-icon-success"></i>
                    </label>
                </div>
                <div class="col-xs-3">
                    <img src="{{ $shop_cart->sm_image }}" class="img-responsive"/>
                </div>
                <div class="col-xs-6">
                    <p>{{ $shop_cart->name }}</p>
                    <small>{{ $shop_cart->attr_name_values }}</small>
                </div>
                <div class="col-xs-2">
                    <div class="RMBnum"><i class="fa fa-rmb"></i><span>{{ $shop_cart->price }}</span>
                        <br>x<tt>{{ $shop_cart->shop_number }}</tt></div>
                </div>
                <div class="me-edit">
                    <button class="edit-min">-</button><input type="text" value="1" readonly="readonly" /><button class="edit-add">+</button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="center-block" style="display:none">
        <span class="fa fa-cart-plus fa-5x"></span>
        <h3>您的购物车还是空的</h3>
        <p>去挑一些中意的商品吧</p>
        <a href="javascript:;" class="weui-btn weui-btn_primary" style="">去商店逛逛</a>
    </div>
    <!--****************  结算  ********************-->
    <div calss="container" id="bill">
        <div class="row ">
            <div class="col-xs-4">
                <label for='all' class="me-checkbox-icon">
                    <input id="all" type="checkbox" name="selectAll" />
                    <i class="weui-icon-success"></i>
                </label><b>全选</b>
            </div>
            <div class="col-xs-4">
                <span>合计: <i class="fa fa-rmb"></i><tt>0.00</tt></span>
            </div>
            <div class="col-xs-4" name="num">
                <a id="sub" class="weui-btn weui-btn_warn" href="shoppCar/settlement.html" >结算(<span>0</span>)
                </a>
            </div>
            <div class="col-xs-4" >
                <a class="weui-btn weui-btn_warn" style="">加入收藏夹</a>
            </div>
            <div class="col-xs-4" >
                <a class="weui-btn weui-btn_warn showIOSDialog1" name="deledeAll">删除</a>
            </div>
        </div>
    </div>
    <!--是否删除购物车商品-->
    <div id="dialogs">
        <div class="js_dialog" id="iosDialog1" style="display: none">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__hd"><strong class="weui-dialog__title">您确定要删除吗</strong></div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" id="okDelete" class="weui-dialog__btn weui-cell_warn me-font-f90">确定删除</a>
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">点错了</a>
                </div>
            </div>
        </div>
    </div>
    <!--*************** 底部导航 ********************-->
    @include('layouts.bottom_nav')
@stop
@section('js')
    <script type="text/javascript" src="/js/shopping_car.js"></script>
    <script>

    </script>
@stop