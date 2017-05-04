@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food.css"/>
<style>
    .food-nav .active a{
        color: #d04c4c;
    }
</style>
@stop
@section('content')
    <!--顶部-->
    <div class="me-header-top">
        <div><a href="/"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        @if($goods->category_name)
            <div>
                {{ $goods->category_name }}
            </div>
        @endif
    </div>
    <!--导航-->
    <div class="row food-nav">
        <div class="col-xs-4 {{ request('order', 'sort') == 'sort'?'active':'' }}" style="font-size: 14px">
            <a href="?category_id={{ request('category_id')?:'' }}&key={{ request('key')?:'' }}&order=sort&sort=asc">
                默认排序 <span class="caret"></span>
            </a>
        </div>
        <div class="col-xs-4 {{ request('order') == 'buy_count'?'active':'' }}" style="font-size: 14px">
            <a href="?category_id={{ request('category_id')?:'' }}&key={{ request('key')?:null }}&order=buy_count&sort=desc">
                销量优先 <span class="caret"></span>
            </a>
        </div>
        <div class="col-xs-4">
            <a href=""/>
                价格降序 <span class="caret"></span>
            </a>
        </div>
    </div>
    <!--****************   商品列表 ********************-->
    <div class="me-goods-List" style="margin-top:70px">
        <div class="me-goods-List" style="margin-top:70px">
            @foreach($goods as $g)
                <div class="shopp-item">
                    <a class="me-on-a" href="/goods/{{ $g->id }}">
                        <img class="img-responsive " src="{{ $g->mid_image }}"/>
                        <p>{{ $g->name }}</p>
                    </a>
                    <p>
                        <span>￥99</span>
                        <small>销量:{{ $g->buy_count }}</small>
                        <a onclick="addShopCart({{ $g->id }})"><img src="/images/cart.svg" style="width: 1.8em" alt=""></a >
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    <!--分页按钮-->
    <div>
        {{ $goods->appends([
            'category_id'=>request('category_id'),
            'key'=>request('key'),
            'order'=>request('order'),
            'sort' => request('sort'),
        ])->links('goods.goods_list_page') }}
    </div>
    <!--**********   底部导航  **************-->
    @include('layouts.bottom_nav')
@stop
@section('js')
<script>
	
</script>
@stop