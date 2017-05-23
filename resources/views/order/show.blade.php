@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>

</style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ url('orders').'?is_pay='.request('is_pay') }}"><i class="icon icon-back icon-lg"></i></a></div>
        <div>订单详情</div>
        <div></div>
    </div>
    <div class="height-2rem"></div>

    @if($order->paid_at)
        <div class="order-info-status">
            <div class="order-i-s-l ok">付款成功 （〜^㉨^)〜 </div>
            <div class="order-i-s-r"><i class="icon icon-present icon-4rem" style="color: #E91E63"></i></div>
        </div>
    @else
        @if($order->orderGoods[0]->status == 3)
            <div class="order-info-status">
                <div class="order-i-s-l ok">订单已关闭</div>
                <div class="order-i-s-r"><i class="icon icon-roundclose icon-4rem" style="color: #f44336"></i></div>
            </div>
        @else
            <div class="order-info-status">
                <div class="order-i-s-l">
                    <p>等待买家付款</p>
                    <p>2小时内自动关闭</p>
                </div>
                <div class="order-i-s-r">
                    <i class="icon icon-pay icon-4rem" style="color: #f44336"></i>
                </div>
            </div>
        @endif
    @endif
    <!--**********  交易状态  *************-->
    <!--**********  地址  *************-->
    <div class="container me-address">
        <div class="row address">
            <div class="col-xs-1 me-a">
                <i class="icon icon-locationfill icon-lg me-font-f90"></i>
            </div>
            <div class="col-xs-11" >
                <p>收货人：<b>{{ $order->name }}</b> <tt>{{ $order->phone }}</tt></p>
                <p>惠州市技师学院，{{ $order->floor_name }}，{{ $order->number }}</p>
            </div>
        </div>
    </div>
    <!--全部订单-->
    <!--****************   商品列表 ********************-->
    <div class="container order-list" id="shoppingList">
        <div class="order-item">
            <div class="order-head">
                <span class="success"></span>
            </div>
            <?php $sum_price=0 ?>
            @foreach($order->orderGoods as $item)
                <a href="{{ url('goods').'/'.$item->goods_id }}">
                    <div class="row">
                        <div class="col-xs-3">
                            <img src="{{ $item->sm_image }}" class="img-responsive"/>
                        </div>
                        <div class="col-xs-7">
                            <p>{{ $item->goods_name }}</p>
                            <small>{{ $item->goods_attributes }}</small>
                        </div>
                        <div class="col-xs-2">
                            <div class="pull-right">
                                <span class="">￥{{ $item->shop_price }}</span>
                                <br>
                                <span class="pull-right">
                                 ×{{ $item->shop_number }}
                            </span>
                            </div>
                            @if($item->status == 0 && $order->paid_at)
                                <span class="pull-right" style="color: orange">未处理</span>
                            @elseif($item->status == 1 && $order->paid_at)
                                <span class="pull-right" style="color: #2196f3">已处理</span>
                            @elseif($item->status == 2 && $order->paid_at)
                                <span class="pull-right" style="color: #57bb5b">已完成</span>
                            @elseif($item->status == 3)
                                <span class="pull-right" style="color: red">已关闭</span>
                            @endif
                        </div>
                    </div>
                </a>
                @if(!$loop->last)
                    <hr>
                @endif
                <?php $sum_price += $item->shop_price * $item->shop_number ?>
            @endforeach
            <div class="order-bottom">
                <!--div class="">日期:2017-5-5-</div><hr/-->
                <div class="price">共{{ count($order->orderGoods) }}件商品 合计：<span>￥{{ sprintf("%.2f", $sum_price) }}</span></div>
                {{--没有被关闭的订单才实付款--}}
                @if($order->orderGoods[0]->status !== 3)
                    <hr>
                    <div class="price">实付款：<span>￥{{ $order->total_price }}</span></div>
                @endif
            </div>
        </div>
    </div>

    <div class="order-info-number">
        <div class="">订单编号：{{ $order->order_id }} <span class="pull-right " >{{--复制--}}</span></div>
        <div class="">创建时间：{{ $order->created_at }}</div>
        @if($order->paid_at)
            <div class="">付款时间：{{ $order->paid_at }}</div>
        @endif
    </div>

    <div class="height-2rem"></div>
    <!--没有支付 && 没有关闭订单 则显示-->
    @if(!$order->paid_at && $order->orderGoods[0]->status !== 3)
        <div class="order-info-bottom">
            <div class="order-i-b-r">
                <a class="me-btn me-a cancel-order">关闭订单</a>
                <a class="me-btn me-a pay-order">去付款</a>
            </div>
        </div>
    @endif
@stop
@section('js')
<script>
    $('.cancel-order').click(function () {
        weui.confirm('你确定要关闭该订单吗？', ()=> {
            let loading = weui.loading('请稍等');
            setTimeout(function () { //如果超过5秒钟没有响应则自动关闭loading框,并提示一个超时响应
                loading.hide(function() {
                    weui.topTips('请求超时', 3000);
                });
            }, 5000);
            $.ajax({
                type: "DELETE",
                url: "/orders/{{ $order->id }}",
                success: function(msg){
                    loading.hide(function () {
                        weui.toast('订单已关闭');
                    });
                    location.reload();
                },
                error: function (error) { //200以外的状态码走这里
                    loading.hide();
                    console.log(error.responseJSON);
                }
            });
        });
    });

    /**
     * 重新下单
     */
    $('.pay-order').click(function () {
        let loading = weui.loading('订单检测中');
        setTimeout(function () { //如果超过5秒钟没有响应则自动关闭loading框,并提示一个超时响应
            loading.hide(function() {
                weui.topTips('请求超时', 3000);
            });
        }, 10000);

        //根据order_id再次申请支付
        $.ajax({
            type: "POST",
            url: "{{ url('/orders/repay') }}",
            data:{
                'order_id': {{ $order->id }}
            },
            success: function(msg){
                loading.hide();
                //使用微信浏览器自带的功能发起支付
                WeixinJSBridge.invoke(
                    'getBrandWCPayRequest', msg.config,
                    function(res){
                        if(res.err_msg == "get_brand_wcpay_request:ok") {
                            // 使用以上方式判断前端返回,微信团队郑重提示：
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
                if(error.status == 500){
                    weui.alert('系统错误,请联系客服');
                    return
                }
                weui.alert(error.responseText);


            }
        });
    })
</script>
@stop