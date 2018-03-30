@extends('layouts.app')
@section('css')
<style>

</style>
@stop
@section('content')
    <div class="weui-flex search-top">
        <div class="return">
            <a href="/">
                <i class="icon icon-home"></i>
            </a>
        </div>
        <div class="weui-flex__item">
            <div class="weui-search-bar" id="searchBar">
                <form class="weui-search-bar__form" method="get" action="{{ url('goods') }}">
                    <div class="weui-search-bar__box">
                        <i class="weui-icon-search"></i>
                        <input type="search" name="key" class="weui-search-bar__input" id="searchInput" value="" placeholder="请输入关键字" required="">
                        <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                    </div>
                    <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                        <span>搜索商品</span>
                    </label>
                </form>
                <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
            </div>
        </div>
    </div>
    <!-- 分类 -->
    <div class="classify">
        @foreach($categories as $category)
            <div class="classify-item">
                <a href="/goods?category_id={{ $category->id }}">
                    <div class="classify-img" style="background-image:url({{ $category->logo }});"></div>
                    <div class="classify-mask"></div>
                    <div class="classify-word">{{ $category->name }}</div>
                </a>
            </div>
        @endforeach
    </div>
@stop
@section('js')
<script>
    //searchBar
    weui.searchBar('#searchBar');
</script>
@stop