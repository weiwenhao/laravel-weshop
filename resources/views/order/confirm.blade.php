@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/shopping_car.css"/>
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <div class="me-header-top">
        {{--todo 这里点了返回之后,ajax清空一下session--}}
        <div><a href="{{ request()->cookie('confirm_exit_url')?:'/' }}"><span class="icon icon-back icon-lg"></span></a></div>
        <div>确认订单</div>
        <div></div>
    </div>
    @if($goods)
        <!--收货-->
        <div class="height-2rem"></div>
        <div class="container me-address me-a">
            @if($addr)
                <a href="{{ url('orders/confirm/addrs') }}">
                    <div class="row address">
                        <div class="col-xs-1">
                            <i class="icon icon-locationfill me-font-f90"></i>
                        </div>
                        <div class="col-xs-10">
                            <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                            <p>惠州市技师学院,{{ $addr->floor_name }},{{ $addr->number }}</p>
                        </div>
                        <div class="col-xs-1">
                            <i class="icon icon-right"></i>
                        </div>
                    </div>
                </a>
            @else
                <a  href="{{ url('orders/confirm/addrs') }}">
                    <div class="row address">
                        <div class="col-xs-11 text-center">
                            <div class="me-font-f90 address-new"><i class="icon icon-locationfill me-font-f90"></i>  点击选择收货地址</div>
                        </div>
                        <div class="col-xs-1">
                            <i class="icon icon-right"></i>
                        </div>
                    </div>
                </a>
            @endif
        </div>

        <!--****************   商品列表 ********************-->
        <div class="container" id="shoppingList" >
            <?php  $sum_price=0;?>
            @foreach($goods as $item)
                <div class="row">
                    <div class="col-xs-3">
                        <img src="{{ $item->sm_image }}" class="img-responsive"/>
                    </div>
                    <div class="col-xs-7">
                        <p>{{ $item->name }}</p>
                        <small>{{ $item->attr_name_values }}</small>
                    </div>
                    <div class="col-xs-2">
                        <div class="RMBnum"></i><span class="price-decimal-point">{{ $item->shop_price }}</span><br>x<tt>{{ $item->shop_number }}</tt></div>
                    </div>
                </div>
                <?php $sum_price+= $item->shop_price*$item->shop_number?>
            @endforeach
        </div>
        <!---->
        <a class="weui-cell weui-cell_access me-fff" >
            <div class="weui-cell__bd">
                支付方式
            </div>
            <div class="weui-cell__ft">微信支付</div>
        </a>
        <a class="weui-cell weui-cell_access me-fff" >
            <div class="weui-cell__bd">
                配送费
            </div>
            <div class="weui-cell__ft">￥0.00</div>
        </a>
        <div class="weui-cell me-fff">
            <div class="weui-cell__hd">订单备注：</div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" name="remarks" placeholder="">
            </div>
        </div>
        <div class="height-4rem"></div>
        <!--****************结算********************-->
        <div calss="container" id="bill">
            <div class="row">
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    <span>合计:<tt>￥{{ sprintf("%.2f", $sum_price) }}</tt></span>
                </div>
                <div class="col-xs-4" name="">
                    <a href="javascript:void(0)" class="weui-btn weui-btn_warn"  id="submit-order">提交订单</a>
                </div>
            </div>
        </div>
    @else
        <div class="weshop-center-block no-goods" style="block;">
            <i class="icon icon-form"></i>
            <div class="title">什么都没有呢</div>
            <div>去挑一些喜欢的商品吧</div>
            <a href="{{ url('/') }}" class="weui-btn  weui-btn_primary" style="">再去逛逛</a>
        </div>
    @endif
@stop
@section('js')
    <script>
        $('#submit-order').click(function (event) {
            event.preventDefault();

            //弹出等待框
            let loading = weui.loading('库存检测中');
            setTimeout(function () { //如果超过5秒钟没有响应则自动关闭loading框,并提示一个超时响应
                loading.hide(function() {
                    weui.topTips('请求超时', 3000);
                });
            }, 10000);

            $.ajax({
                type: "POST",
                url: "{{ url('/orders') }}",
                data : {
                  'remarks': $('input[name=remarks]').val()
                },
                success: function(msg){
                    loading.hide();
                    //使用微信浏览器自带的功能发起支付
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest', msg.config,
                        function(res){
                            if(res.err_msg == "get_brand_wcpay_request:ok") {
                             // 使用以上方式判断前端返回,微信团队郑重提示：
                             // res.err_msg将在用户支付成功后返回
                             // ok，但并不保证它绝对可靠。
                             //跳转到订单详情页?
                                location.href = '{{ url('orders') }}/'+msg.order_id+'?is_pay=1'
                             }
                             if("get_brand_wcpay_request:cancel" || "get_brand_wcpay_request:fail"){
                                 location.href = '{{ url('orders') }}/'+msg.order_id+'?is_pay=0'
                             }
                        }
                    );
                },
                error: function (error) { //200以外的状态码走这里
                    loading.hide();
                    if(error.status == 422){
                        weui.alert(error.responseText, { title: '无法完成订单' });
                    }else {
                        weui.alert(error.responseText);
                    }
                }
            });
        });
    </script>
@stop