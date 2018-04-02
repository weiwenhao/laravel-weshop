<div style="height: 3.5rem"></div>
<div class="weui-tabbar">
    <a class="weui-tabbar__item" href="{{ url('/') }}">
        <i class="weui-tabbar__icon"><i class="icon {{ request()->is('index*') || request()->is('/') ?'icon-homefill active':'icon-home' }}"></i></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a class="weui-tabbar__item" href="{{ url('posts') }}">
        <i class="weui-tabbar__icon"><i class="icon {{ request()->is('news*')?'icon-discoverfill active':'icon-discover' }}"></i></i>
        <p class="weui-tabbar__label">逛一逛</p>
    </a>
    <a class="weui-tabbar__item" href="{{ url('shop_carts') }}">
        <i class="weui-tabbar__icon"><i class="icon {{ request()->is('shop_carts*')?'icon-cartfill active':'icon-cart' }}"></i></i>
        <p class="weui-tabbar__label">购物车</p>
    </a>
    <a class="weui-tabbar__item" href="{{ url('me') }}">
        <i class=" weui-tabbar__icon"><i class="icon {{ request()->is('me*')?'icon-myfill active':'icon-my' }}"></i></i>
        <p class="weui-tabbar__label">个人中心</p>
    </a>
</div>