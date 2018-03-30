<div class="weui-loadmore weui-loadmore_line">
    <span class="weui-loadmore__tips your-like"><i class="icon icon-likefill" style="color: red"></i> 猜你喜欢</span>
</div>
<div class="me-goods-List">
    @foreach($like_goods as $goods)
        <div class="shopp-item">
            <a class="me-on-a me-a"  href="{{ url('/goods/'.$goods->id) }}">
                <!--添加name='off'出现下架-->
                <img class="img-responsive" data-img="{{ $goods->mid_image }}"/>
                <p>{{ $goods->name }}</p>
            </a>
            <p>
                <span class="price-decimal-point">{{ $goods->price }}</span>
                <small>销量:{{ $goods->buy_count }}</small>
                <a class="icon icon-favor collect" goods_id="{{ $goods->id }}"></a>
            </p>
        </div>
    @endforeach
</div>