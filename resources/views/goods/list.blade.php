@extends('layouts.app')
@section('css')
<style>
    .goods-list > .shaixuan {
        z-index: 100;
        width: 100%; /*适应fixed*/
        border-bottom: 1px #e8e8e8 solid ;
    }
    .goods-list > .shaixuan > div {
        text-align: center;
        background-color: #fff;
    }
    .goods-list > .shaixuan > .active > a {
        color: #ff005c;
    }
    .goods-list > .top-nav {
        background-color: #f90;
        line-height: 2.2rem;
        color: #fff;
    }
    .goods-list > .top-nav a {
        color: #fff;
    }
    .goods-list {
        margin-bottom: 2.3rem;
    }
</style>
@stop
@section('content')
    <div class="goods-list">
        {{--nav--}}
        <div class="weui-flex top-nav">
            <div>
                <a href="/"><span class="fa fa-chevron-left fa-lg"></span></a>
            </div>
            <div class="weui-flex__item text-center">
                @if($goods->category_name)
                    <div>
                        <b>{{ $goods->category_name }}</b>
                    </div>
                @endif
            </div>
            <div>
                <div>&nbsp;&nbsp;&nbsp;</div>
            </div>
        </div>
        <!--导航-->
        <div class="weui-flex shaixuan">
            <div class="weui-flex__item {{ request('order') ?'':'active' }}">
                <a href="?category_id={{ request('category_id') }}">综合排序</a>
            </div>
            <div class="weui-flex__item {{ request('order')=='buy_count'?'active':'' }}">
                <a href="?category_id={{ request('category_id') }}&order=buy_count"> {{--销量默认使用的是desc--}}
                    销量优先
                </a>
            </div>
            <div class="weui-flex__item {{ request('order') == 'price'?'active':'' }}">
                <a href="?category_id={{ request('category_id') }}&order=price&sort={{request('sort') == 'asc'?'desc':'asc'}}">
                    价格排序 <span class="fa {{ request('sort')=='desc'?'fa-angle-down':'fa-angle-up' }}"></span>
                </a>
            </div>
        </div>
        <!--****************   商品列表 ********************-->
        <div class="me-goods-List">
            @foreach($goods as $item)
                <div class="shopp-item">
                    <a class="me-on-a me-a" href="{{ url('goods').'/'.$item->id  }}">
                        <img class="img-responsive {{ $item->is_on_sale?'':'off-sale' }}" src="" data-img="{{ $item->mid_image }}"/>
                        <p>{{ $item->name}}</p>
                    </a>
                    <p>
                        <span class="price-decimal-point">{{ $item->price }}</span>
                        <small>销量:{{ $item->buy_count }}</small>
                        <a class=" fa fa-heart-o collect" goods_id="{{ $item->id }}"></a>
                    </p>
                </div>
            @endforeach
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
    </div>
    <!--**********   底部导航  **************-->
    @include('layouts.bottom_nav')
@stop
@section('js')
<script>
    var ofsy = 0;//window顶部偏移,默认为0,不便宜
    var shaixuan_height = $('.shaixuan').height();
	$(window).scroll(function () {
        let shaixuan_top = $('.shaixuan').offset().top //当前div到窗口顶部的距离,固定值

        if(this.scrollY > ofsy  && ofsy > shaixuan_top+(shaixuan_top/3)){
            // position: fixed;
            // position: static;
            $('.shaixuan').css('position', 'fixed');
            $('.shaixuan').css('top', '0');
        }
        if(this.scrollY < ofsy && this.scrollY < shaixuan_height){
            $('.shaixuan').css('position', 'static');
            $('.shaixuan').css('top', '0');
        }
        ofsy = this.scrollY //记录值
    })


</script>
@stop