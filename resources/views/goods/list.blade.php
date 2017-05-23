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
        line-height: 2rem;
        font-size: 0.9rem;
    }
    .goods-list > .shaixuan > .active > a {
        color: #ff005c;
    }
    .goods-list > .top-nav {
        background: -webkit-linear-gradient(left, #FECA00 , #FE9500) ;
        background: linear-gradient(to right, #FECA00 , #FE9500) ;
        line-height: 2.2rem;
        color: #fff;
    }
    .goods-list > .top-nav a {
        color: #fff;
    }
    .goods-list {
        margin-bottom: 2.3rem;
    }
    .goods-list i.sort {
        font-size: 0.8rem
    }
</style>
@stop
@section('content')
    <div class="goods-list">
        {{--nav--}}
        @if(isset($goods->category_name))
            <div class="weui-flex top-nav">
                <div>
                    <a href="{{ request()->cookie('goods_exit_url')?:url('/') }}"><span class="icon icon-back icon-lg"></span></a>
                </div>
                <div class="weui-flex__item text-center">
                    <div>
                        <b>{{ $goods->category_name }}</b>
                    </div>
                </div>
                <div>
                    <div>&nbsp;&nbsp;&nbsp;</div>
                </div>
            </div>
        @elseif(request('key'))
            <div class="weui-flex search-top">
                <div class="return">
                    <a href="{{ request()->cookie('goods_exit_url')?:url('/') }}">
                        <i class="icon icon-back"></i>
                    </a>
                </div>
                <div class="weui-flex__item">
                    <div class="weui-search-bar" id="searchBar">
                        <form class="weui-search-bar__form" method="get" action="{{ url('goods') }}">
                            <div class="weui-search-bar__box">
                                <i class="weui-icon-search"></i>
                                <input type="search" name="key" class="weui-search-bar__input" id="searchInput" value="" placeholder="{{ request('key') }}" required="">
                                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                            </div>
                            <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                                <span>“{{ request('key') }}”</span>
                            </label>
                        </form>
                        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
                    </div>
                </div>
            </div>
        @endif
        <!--导航-->
        <div class="weui-flex shaixuan">
            <div class="weui-flex__item {{ request('order') ?'':'active' }}">
                <a href="?category_id={{ request('category_id') }}&key={{ request('key') }}">综合排序</a>
            </div>
            <div class="weui-flex__item {{ request('order')=='buy_count'?'active':'' }}">
                <a href="?category_id={{ request('category_id') }}&key={{ request('key') }}&order=buy_count"> {{--销量默认使用的是desc--}}
                    销量优先
                </a>
            </div>
            <div class="weui-flex__item {{ request('order') == 'price'?'active':'' }}">
                <a href="?category_id={{ request('category_id') }}&key={{ request('key') }}&order=price&sort={{request('sort') == 'asc'?'desc':'asc'}}">
                    价格排序 <i class="sort icon {{ request('sort')=='desc'?'icon-downfill':'icon-upfill' }}"></i>
                </a>
            </div>
        </div>

        <!--****************   商品列表 ********************-->
        <div class="me-goods-List">
            @foreach($goods as $item)
                <div class="shopp-item">
                    <a class="me-on-a me-a" href="{{ url('goods').'/'.$item->id  }}">
                        <img class="img-responsive {{ $item->is_sale?'':'off-sale' }}" src="" data-img="{{ $item->mid_image }}"/>
                        <p>{{ $item->name}}</p>
                    </a>
                    <p>
                        <span class="price-decimal-point">{{ $item->price }}</span>
                        <small>销量:{{ $item->buy_count }}</small>
                        <a class="icon icon-favor collect" goods_id="{{ $item->id }}"></a>
                    </p>
                </div>
            @endforeach
        </div>
        {{--商品为空时--}}
        <div class="weshop-center-block no-goods" style="display:{{ $goods->total()?'none':'block' }}">
            <i class="icon icon-goods"></i>
            <div class="title">暂时没有相关商品</div>
            {{--精品推荐--}}
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
@stop
@section('js')
<script>
    //searchBar
    weui.searchBar('#searchBar');

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