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
        <div>{{--<a id="previous_page"><span class="fa fa-chevron-left fa-lg"></span></a>--}}</div>
        <div>购物车</div>
        <div><a id="me_edit">编辑</a></div>
    </div>
    <!--****************   购物车列表.2.0 ********************-->
    <div class="height-2rem"></div>
    <div class="container shopping-hoem" id="shoppingList">
        @foreach($shop_carts as $shop_cart)
            <div class="row">
                    <!--添加name='off'出现下架-->
                    <div class="col-xs-1 {{ $shop_cart->is_on_sale?($shop_cart->number == 0?'off-number':''):'off-sale' }} "><!--选项-->
                        <label for='{{ $loop->index }}' class="me-checkbox-icon">
                            <input id="{{ $loop->index }}" class="shop_cart" type="checkbox" name="select"
                                   {{--如果购买数量小于或者等于库存量(常见情况),则不需要修改数据库,所以传递一个空到后台,否则把仅剩的库存量传递到后台,修改购物车中的库存量--}}
                                   shop_number="{{ $shop_cart->shop_number <= $shop_cart->number?'':$shop_cart->number }}"
                                   value="{{ $shop_cart->id }}"
                            />
                            <i class="weui-icon-success"></i>
                        </label>
                    </div>
                    <a href="{{ url('goods/'.$shop_cart->goods_id) }}">
                        <div class="col-xs-3">
                            <div class="wrap-img">
                                <img src="{{ $shop_cart->sm_image }}" class="img-responsive"/>
                                @if($shop_cart->number<=5 && $shop_cart->number > 0)
                                    <span class="rest">仅剩{{ $shop_cart->number }}件</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    <div class="col-xs-6">
                        <a href="{{ url('goods/'.$shop_cart->goods_id) }}">
                            <p>{{ $shop_cart->name }}</p>
                        </a>
                        <small>{{ $shop_cart->attr_name_values }}</small>
                        </div>
                    <div class="col-xs-2">
                        <div class="RMBnum">
                            <span class="price-decimal-point">{{ $shop_cart->price?:$shop_cart->goods_price }}</span>
                            <br>x<tt>{{ $shop_cart->shop_number <= $shop_cart->number?$shop_cart->shop_number:$shop_cart->number }}</tt>
                        </div>
                    </div>
                    <div class="me-edit">
                        <button class="edit-min">-</button><input
                                type="text"
                                name="shop_number"
                                value="{{ $shop_cart->shop_number <= $shop_cart->number?$shop_cart->shop_number:$shop_cart->number }}"
                                shop_cart_id="{{ $shop_cart->id }}"
                                data-max="{{ $shop_cart->number }}"
                                readonly="readonly"
                        /><button class="edit-add">+</button>
                    </div>
                </div>
        @endforeach
    </div>
    <div class="weshop-center-block no-goods" style="display:{{ $shop_carts->toArray()?'none':'block' }}">
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
                <div class="col-xs-4">
                    <button class="weui-btn weui-btn_warn" id="del-shop-carts" name="deleteAll">删除</button>
                </div>
            </div>
        </div>
    <!--*************** 底部导航 ********************-->
    @include('layouts.bottom_nav')
@stop
@section('js')
    <script type="text/javascript" src="/js/shopping_car.js"></script>
    <script>
        /**
         *
         * 结算操作
         * */
        $('#sub').click(function () {
            //判断用户是否选择了商品
            let shop_cart_ids =  [];
            let shop_numbers = [];
            $('.shop_cart:checked').each(function (index, dom) {
                shop_cart_ids[index] = $(dom).val();
                shop_numbers[index] = $(dom).attr('shop_number');
            });
            if(shop_cart_ids == ''){
                alert('您还没有选择商品呢!');
                return;
            }
            $.ajax({
            	type: "POST",
            	url: "{{ url('/orders/shop_cart_confirm') }}",
            	data:{
            	    'shop_cart_ids' : shop_cart_ids,
                    'shop_numbers' : shop_numbers
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
        /**
         * 更改购物车库存,采集初始值
         */
        var shop_numbers = [];
        //计算shop_cart_id
        $('#me_edit').click(function () {
            if($(this).text() != '完成'){
                shop_numbers = getShopNum(); //点击编辑的时候计算一次
                return
            }
            let data = [];
            //再次计算一下value值
            $('[name=shop_number]').each(function (index, dom) {
                let id = $(this).attr('shop_cart_id');
                if($(this).val() != shop_numbers[id] ){ //
                    data.push({
                        'id' : id,
                        'shop_number' : $(this).val()
                    })
                }
            })

            if(data == ''){  // [] == ''  true   [] == [] false
                return;
            }
            editShopNum(data);
        });


        /**
         *ajax请求更改购物车商品数量
         */
        function editShopNum(data) {
            $.ajax({
                type: "PUT",
                url: "shop_carts",
                data:{
                    'shop_numbers': data
                },
                success: function(msg){
                    console.log(msg);
                },
                error: function (error) { //200以外的状态码走这里
                    console.log(error.responseText);
                }
            });
        }
        /**
         * 计算购物车数量初始值
         * @returns {Array}
         */
        function getShopNum(){
            let data = [];
            $('[name=shop_number]').each(function (index, dom) {
                data[$(this).attr('shop_cart_id')] = $(this).val();
            })
            return data;
        }
        /**
         * ajax删除商品
         */
        function ajaxDelGoods() {
            //得到勾选的商品
            let shop_cart_ids =  [];
            $('.shop_cart:checked').each(function (index, dom) {
                shop_cart_ids[index] = $(dom).val();
            });
            //发送到后台
            $.ajax({
            	type: "DELETE",
            	url: "/shop_carts",
            	data:{
            	    'shop_cart_ids':shop_cart_ids
                },
            	success: function(msg){

            	},
            	error: function (error) { //200以外的状态码走这里

            	}
            });
        }
    </script>
@stop