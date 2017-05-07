@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food_info.css"/>
<style>

</style>
@stop
@section('content')
    <!--**************** 顶部 ********************-->
    <div class="me-header-top me-header-food-info">
        <div><a href="{{ url()->previous() }}" id="historyPageGo"><span class="fa fa-chevron-left "></span></a></div>
        <div></div>
        <div><a href="{{ url('shop_carts') }}"><span class="fa fa-cart-plus "></span></a></div>
    </div>
    <!--**************** 详情 ********************-->
    <div class="goods-info-img">
        <img class="img-responsive" src="{{ $goods->big_image }}" />
    </div>
    <div class="goods-info-img-empty" id="showAndroidActionSheet"></div>
    <div class="goods-info">
        <div class="goods-list goods-info-name"><p>{{ $goods->name }}</p></div>
        <div class="goods-list goods-info-price">
            <span class="price-decimal-point"><i class="fa fa-rmb"></i>{{ $goods->price }} </span> {{--<del> <i class="fa fa-rmb"></i>2099</del>--}}
            <small><i class="fa fa-line-chart"></i> 销量：{{ $goods->buy_count }}</small>
        </div>
        <div class="goods-list weui-cell">
            <div class="weui-cell__hd">
            </div>
            <div class="weui-cell__bd">
               ..
            </div>
            <div class="weui-cell__ft">..</div>
        </div>
        <div class="goods-list goods-info-txt">
            <h4>商品详情</h4>
            {!! $goods->description !!}
        </div>
    </div>
    <!--点击图片查看大图-->
    <div class="page actionsheet">
        <div class="weui-skin_android" id="androidActionsheet" style="display:none">
            <div class="weui-mask"></div>
            <div class="weui-actionsheet">
                <img class="img-responsive" src="{{ $goods->big_image }}" />
                <span class="fa fa-times-circle-o fa-2x" id="outImg"></span>
            </div>
        </div>
    </div>
    <!--**************** 加入购物车 立即购买 ********************-->
    <div calss="container" id="mai">
        <div class="row">
            <div class="col-xs-4">
                <a class="weui-btn weui-btn_warn" ><i class="fa fa-star"></i> 加入收藏</a>
            </div>
            <div class="col-xs-4">
                <a class="weui-btn weui-btn_warn showIOSActionSheet" ></i> 加入购物车</a>
            </div>
            <div class="col-xs-4 {{ $goods->is_on_sale?'':"off-sale" }}"><!--添加name='off'显示已下架-->
                <a class="weui-btn weui-btn_warn showIOSActionSheet"  >立即购买</a>
            </div>
        </div>
    </div>
    <!--*************** 弹出菜单 ********************-->
    <!--*************** 弹出菜单 ********************-->
    <div class="weui-mask" id="iosMask" style="display:none"><!--灰色--></div>
    <div class="weui-actionsheet me-out-nav" id="actionsheet">
        <div class="me-actionsheet-title">
            <img class="img-rounded img-thumbnail" src="{{ $goods->sm_image }}" />
            <div class="me-right">
                <span id="iosActionsheetCancel" class="fa fa-times-circle-o fa-lg"></span>
                <p class="price"><i class="fa fa-rmb"></i> <span>{{ $goods->price }}</span></p>
                @if($goods->option_attrs)
                    <p class="class-ok">已选: <span class="attr-target"></span></p>
                @endif
            </div>
        </div>
        <div class="me-actionsheet-body">
            @foreach($goods->option_attrs as $attr_name => $attr_values)
                <p>{{ $attr_name }}</p>
                <p class="attr">
                    @foreach($attr_values as $value)
                        <label for="{{ $value->goods_attribute_id }}">
                            <input type="radio"
                                   class="attr-value"
                                   name="{{ $attr_name }}"
                                   id="{{ $value->goods_attribute_id }}"
                                   value="{{ $value->goods_attribute_id }}"
                                    {{ $loop->first?'checked':'' }}
                            />
                            <span>{{ $value->attribute_value }}</span>
                        </label>
                    @endforeach
                </p>
            @endforeach
            <div class="weui-actionsheet__cell buy-count">
                <span class="pull-left">购买数量 </span>
                <span class="pull-right">
                   <button class="min">-</button><input name="shop_number" type="text" style="" value="1" readonly/><button class="add">+</button>
                </span>
            </div>
        </div>
        <div class="me-actionsheet-bottom">
            <a href="" class="weui-btn weui-btn_warn me-ok me-back-f90" id="addShopCart">加入购物车</a>
            <a href="" class="weui-btn weui-btn_warn me-ok">立即购买</a>
        </div>
    </div>
@stop
@section('js')
<script type="text/javascript" src="/js/food.js"></script>
<script>
	//加入购物车操作
    $('#addShopCart').click(function (event) {
        event.preventDefault();
        //得到购买数量
        let shop_number = $('[name=shop_number]').val();
        //得到商品属性
        let goods_attribute_ids = [];
        $('.attr-value:checked').each(function (index, elem) {
            goods_attribute_ids[index] = $(this).val();
        });
        $.ajax({
        	type: "POST",
        	url: "/shop_carts",
        	data:{
        	    'goods_id' : {{$goods->id}},
        	    'shop_number' : shop_number,
        	    'goods_attribute_ids' : goods_attribute_ids,
            },
        	success: function(msg){
        	    //弹出成功
                toast('加入购物车成功');
        	    //关闭下拉框
                $('#iosActionsheetCancel').trigger('click');
                //清空number数量
                $('[name=shop_number]').val(1);

        	},
        	error: function (error) { //200以外的状态码走这里
//                error.responseText; //库存量不足
                 if(error.status == {{ config('shop.no_number') }}){
                     alert('库存量不足')
                 }
        	}
        });

    });
</script>
@stop