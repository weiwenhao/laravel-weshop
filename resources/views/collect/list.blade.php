@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
<style>

</style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="{{ url('me') }}"><span class="icon icon-back icon-lg"></span></a></div>
        <div>我的收藏</div>
        <div></div>
    </div>
    <div class="height-2rem"></div>
    <!--全部订单-->
    <div class="container order-list collect-list" id="shoppingList">
        @foreach($collects as $collect)
            <a href="/goods/{{ $collect->goods_id }}">
                <div class="order-item" style="position: relative">
                    <div class="row" >
                        <div class="col-xs-4">
                            <img src="{{ $collect->sm_image }}" class="img-responsive"/>
                        </div>
                        <div class="col-xs-7">
                            <div>{{ $collect->goods_name }}</div>
                            <div  style="position: absolute;top: 4rem;width: 100%">
                            <span style="color: red;">
                                <i class="icon icon-money" style="font-size: 0.6rem"></i>{{ $collect->goods_price }}
                            </span>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <span class="pull-right" style="margin-right: 0.2rem">
                                <i class="icon icon-likefill no-collect" collect_id="{{ $collect->id }}" style="color: orangered;font-size: 1.5rem"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <!--分页按钮-->
    <div>
        {{ $collects->links('goods.goods_list_page') }}
    </div>
    {{--空收藏--}}
    <div class="weshop-center-block" style="display:{{ $collects->total()?'none':'block' }}">
        <i class="icon icon-like"></i>
        <div class="title">暂时没有收藏</div>
        <div>快去逛逛吧</div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="/js/address.js"></script>
<script>
    $('.no-collect').click(function (event) {
        event.preventDefault();
        weui.confirm('您确定要取消收藏吗?',  () => {
            //移除html
            let  item = $(this).parent().parent().parent().parent();
            item.fadeOut("1000", function () {
                $(this).remove();
                //判断是否还存在收藏,不存在则显示
                if($('.order-item').length == 0){
                    $('.weshop-center-block').css('display', 'block')
                }
            });
            //发送ajax请求取消收藏
            $.ajax({
                type: "DELETE",
                url: "collects/"+$(this).attr('collect_id'),
            });
        });
    });
</script>
@stop