@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>
</style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ request()->cookie('orders_previous_url')?:url('me') }}"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>我的订单</div>
        <div></div>
    </div>
    <div class="height-2rem"></div>
    <!--**********   个人 *************-->
    <div class="me-order-top">
        <div class="order-item">
            <a href="{{ url('orders') }}?is_pay=0" class="{{ request('is_pay') === '0'?'active':'' }}">待付款</a>
        </div>
        <div class="order-item">
            <a href="{{ url('orders') }}?is_pay=1" class="{{ request('is_pay') === '1'?'active':'' }}">已支付</a>
        </div>
        <div class="order-item">
            <a  href="{{ url('orders') }}" class="{{ request('is_pay') === null?'active':'' }}">全部</a>
        </div>
    </div>

    <!--全部订单-->
    <!--****************   商品列表 ********************-->
    <div class="container order-list" id="shoppingList">
        <?php $_count = 0 ?>
        @foreach($orders as $order)
            {{--根据url判断,如果显示的内容是待付款的订单 然后 判断订单中的第一件商品的状态是否为3(已关闭),如果是的话,则跳过该循环--}}
            @continue(request('is_pay') === '0' && $order->orderGoods[0]->status == 3)
            <div class="order-item">
                <div class="order-head">
                    <span>
                        创建时间：{{ $order->created_at }}
                    </span>
                </div>
                @foreach($order->orderGoods as $item)
                    <div class="row">
                        <a href="{{ url('orders/'.$order->id).'?is_pay='.request('is_pay') }}">
                            <div class="col-xs-3">
                                <img src="{{ $item->sm_image }}" class="img-responsive"/>
                            </div>
                            <div class="col-xs-7">
                                <p>{{ $item->goods_name }}</p>
                                <small>{{ $item->goods_attributes }}</small>
                            </div>
                            <div class="col-xs-2">
                                <div class=" pull-right">
                                    <span class="">￥{{ $item->shop_price }}</span>
                                    <br>
                                    <span class="pull-right">
                                    ×{{ $item->shop_number }}
                                </span>
                                </div>
                                @if($item->status == 0)
                                    <span class="pull-right" style="color: orange">未处理</span>
                                @elseif($item->status == 1)
                                    <span class="pull-right" style="color: #2196f3">已处理</span>
                                @elseif($item->status == 2)
                                    <span class="pull-right" style="color: #57bb5b">已完成</span>
                                @elseif($item->status == 3)
                                    <span class="pull-right" style="color: red">已关闭</span>
                                @endif
                            </div>
                        </a>
                    </div>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
                <div class="order-bottom">
                    <div class="price">共{{ count($order->orderGoods) }}件商品 <span class="pull-right">实付款: <b>￥{{ $order->total_price }}</b></span></div><hr/>
                    @if(!$order->paid_at && $order->orderGoods[0]->status !== 3)
                        <span class="p3">&nbsp;</span>
                        <div class="del">
                            <a href="javascript:void(0);" class="weui-btn weui-btn_mini weui-btn_default cancel-order" value="{{ $order->id }}">关闭订单</a>
                            <a href="javascript:void(0);" class="weui-btn weui-btn_mini weui-btn_default pay-order" value="{{ $order->id }}">去付款</a>
                        </div>
                    @endif
                </div>
            </div>
            <?php $_count++ ?>
        @endforeach
        <div class="weshop-center-block" style="display:{{ $_count != 0 ?'none':'block' }};">
            <span class="fa fa-lemon-o fa-5x"></span>
            <h3>您还没有相关订单</h3>
            <p>可以去看看有哪些想买的</p>
        </div>
    </div>
    <div class="height-4rem"></div>
    {{--底部导航--}}
    @include('layouts.bottom_nav')
@stop
@section('js')
<script>
    $('.cancel-order').click(function () {
        if(confirm('你确定要关闭该订单吗？')){
            $.ajax({
            	type: "DELETE",
            	url: "orders/"+$(this).attr('value'),
            	success: function(msg){
            		toast('订单已关闭');
                    location.reload();
            	},
            	error: function (error) { //200以外的状态码走这里
            		 console.log(error.responseJSON);
            	}
            });
        }
    });
    $('.pay-order').click(function () {
        if(!$(this).attr('value')){
            alert('系统错误，请联系客服');
            return;
        }
        //根据order_id再次申请支付
        $.ajax({
            type: "POST",
            url: "{{ url('/orders/repay') }}",
            data:{
              'order_id':$(this).attr('value')
            },
            success: function(msg){
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
                if(error.status == 500){
                    alert('系统错误,请联系客服');
                    return
                }
                alert(error.responseText);
            }
        });
    })
</script>
@stop