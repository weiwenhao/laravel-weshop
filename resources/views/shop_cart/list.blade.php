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
                <div class="col-xs-1 {{ $shop_cart->is_on_sale?'':'off-sale' }}"><!--选项-->
                    <label for='{{ $loop->index }}' class="me-checkbox-icon">
                        <input id="{{ $loop->index }}" class="shop_cart" type="checkbox" name="select" value="{{ $shop_cart->id }}"/>
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
                    <div class="RMBnum"></i><span class="price-decimal-point">{{ $shop_cart->price?:$shop_cart->goods_price }}</span>
                        <br>x<tt>{{ $shop_cart->shop_number }}</tt></div>
                </div>
                <div class="me-edit">
                    <button class="edit-min">-</button><input type="text" value="1"  readonly="readonly" /><button class="edit-add">+</button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="center-block" style="display:{{ $shop_carts->toArray()?'none':'block' }}">
                <span class="fa fa-shopping-cart fa-5x"></span>
                <h3>您的购物车是空的</h3>
                <p>去挑一些喜欢的商品吧</p>
                <a href="{{ url('/') }}" class="weui-btn weui-btn_primary" style="">再去逛逛</a>
            </div>
    <div class="height-2rem"></div>
    <div class="height-4rem"></div>
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
                    <a id="sub" class="weui-btn weui-btn_warn" href="javascript:void(0)" >结算(<span>0</span>)
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
    <!--*************** 底部导航 ********************-->
    @include('layouts.bottom_nav')


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
@stop
@section('js')
    <script type="text/javascript" src="/js/shopping_car.js"></script>
    <script>

        $('#sub').click(function () {
            //判断用户是否选择了商品
            let shop_cart_ids =  [];
            $('.shop_cart:checked').each(function (index, dom) {
                  shop_cart_ids[index] = $(dom).val();
            });
            if(shop_cart_ids == ''){
                alert('您还没有选择商品呢!');
                return;
            }
            $.ajax({
            	type: "POST",
            	url: "{{ url('/orders/confirm') }}",
            	data:{
            	    'shop_cart_ids' : shop_cart_ids
                },
            	success: function(msg){
                     location.href = '{{ url('orders/confirm') }}';
            	},
            	error: function (error) { //200以外的状态码走这里
            		 if(error.status == 422){
            		     alert(error.responseText);
                     }
            	}
            });
        })
    </script>
@stop