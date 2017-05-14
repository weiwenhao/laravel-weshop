@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food_info.css"/>
<style>

</style>
@stop
@section('content')
    <!--**************** 顶部 ********************-->
    <div class="me-header-top me-header-food-info">
        <div><a href="{{ request()->cookie('goods_previous_url')?:'' }}"><span class="fa fa-chevron-left "></span></a></div>
        <div></div>
        <div><a href="{{ url('shop_carts') }}"><span class="fa fa fa-shopping-cart"></span></a></div>
    </div>
    <!--**************** 详情 ********************-->
    <div class="goods-info-img">
        <img class="img-responsive" style="width: 100%" src="{{ $goods->big_image }}" />
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
            <div class="col-xs-4  {{ $goods->is_on_sale?'':"off-sale" }}"><!--添加name='off'显示已下架-->
                <a class="weui-btn weui-btn_warn showIOSActionSheet"  >立即购买</a>
            </div>
        </div>
    </div>
    <!--*************** 弹出菜单 ********************-->
    <div class="weui-mask" id="iosMask" style="display:none"><!--灰色--></div>
    <div class="weui-actionsheet me-out-nav" id="actionsheet">
        <div class="me-actionsheet-title">
            <img class="img-rounded img-thumbnail" src="{{ $goods->sm_image }}" />
            <div class="me-right">
                <span id="iosActionsheetCancel" class="fa fa-times-circle-o fa-lg"></span>
                <p class="price"><i class="fa fa-rmb"></i> <span id="goods_price">{{ $goods->price }}</span></p>
                <div>库存 <span id="goods_number">0</span> 件</div>
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
            <a href="" class="weui-btn weui-btn_warn me-ok" id="lijiShop">立即购买</a>
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
                 if(error.status == 422){
                     alert(error.responseText)
                 }
        	}
        });

    });

    //立即购买操作
    $('#lijiShop').click(function () {
        //得到购买数量
        let shop_number = $('[name=shop_number]').val();
        //得到商品属性
        let goods_attribute_ids = [];
        $('.attr-value:checked').each(function (index, elem) {
            goods_attribute_ids[index] = $(this).val();
        });
        $.ajax({
            type: "POST",
            url: "/orders/goods_confirm",
            data:{
                'goods_id' : {{$goods->id}},
                'shop_number' : shop_number,
                'goods_attribute_ids' : goods_attribute_ids,
            },
            success: function(msg){
                location.href='{{ url('/orders/confirm') }}';
            },
            error: function (error) { //200以外的状态码走这里
//                error.responseText; //库存量不足
                if(error.status == 422){
                    alert(error.responseText)
                }
            }
        });
    })
    //选择属性时确定库存和价格
    $('.attr-value').click(getNumberAndPrice);
    //点击立即购买和加入购物车时分别计算一次属性和库存
    $('.showIOSActionSheet').click(getNumberAndPrice);

    /*
    * 通过ajax从后台得到商品的库存和价格信息
    * */
    var number_price = {};
    (function () {
        $.ajax({
        	type: "get",
        	url: "/goods/number_price",
        	data:{
        	    'goods_id' : {{ $goods->id }}
            },
        	success: function(msg){
        		number_price = msg;
         //后台数据获得后,调用一次该方法,得到商品商品的价格和库存,调用必须在ajax获得后台数据之后 todo 点击加入购物车或者立即购买时进行计算比较好
        	},
        	error: function (error) { //200以外的状态码走这里
        		 console.log(error.responseJSON);
        	}
        });
    })();
    /*
    * 根据用户的选择计算出该属性下商品的属性和库存量,并赋值给对应的html
    * */
    function getNumberAndPrice() {
        //得到商品属性ids
        let goods_attribute_ids = [];
        $('.attr-value:checked').each(function (index, elem) {
            goods_attribute_ids[index] = $(this).val();
        });
        //从小到大排序,且使用逗号关联起来
        goods_attribute_ids.sort(function (a,b) {
            return a-b
        }); //对数组的引用。请注意，数组在原数组上进行排序，不生成副本。
        //拼接出对象名称
        goods_attribute_ids = 'a'+goods_attribute_ids.join('_');
        // xxx[变量]√    xxx.变量 ×
        let number = number_price[goods_attribute_ids].number;
        let price = number_price[goods_attribute_ids].price;
        if(!price){
            price = {{ $goods->price }}
        }
        //赋值操作
        $('#goods_number').text(number);
        $('#goods_price').text(price);

    }


</script>
@stop