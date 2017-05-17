<div class="height-4rem"></div>
<div class="weui-tabbar">
    <a class="weui-tabbar__item" href="{{ url('/') }}">
        <i class="weui-tabbar__icon"><span class="fa fa-home"></span></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a class="weui-tabbar__item" name="wait">
        <i class="weui-tabbar__icon"><span class="fa fa-share-alt"></span></i>
        <p class="weui-tabbar__label">逛一逛</p>
    </a>
    <a class="weui-tabbar__item" href="{{ url('shop_carts') }}">
        <i class="weui-tabbar__icon"><span class="fa fa-shopping-cart"></span></i>
        <p class="weui-tabbar__label">购物车</p>
    </a>
    <a class="weui-tabbar__item" href="{{ url('me') }}">
        <i class=" weui-tabbar__icon"><span class="fa fa-user"></span></i>
        <p class="weui-tabbar__label">个人中心</p>
    </a>
</div>