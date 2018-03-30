<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    {{--ajaxtoken--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>天哪来啦</title>
    <!-- 以下是公共css -->
    <link rel="stylesheet" href="/plugins/weui.css"/>
    <link rel="stylesheet" href="/css/app.css">
    {{--<link rel="stylesheet" href="/css/common.css"/>--}}

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('css')
</head>
<body ontouchstart>
<div id="app">
    @yield('content')
</div>


{{--jssdk--}}
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
{{--weui.js--}}
<script type="text/javascript" src="https://res.wx.qq.com/open/libs/weuijs/1.1.1/weui.min.js"></script>
{{--公共js--}}
<script src="/js/app.js"></script>
<script>
    $.ajaxSetup({ //这段话的意思使用ajax,会将csrf加入请求头中
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * 商品列表页的收藏商品操作,仅收藏
     */
    $('.collect').click(function () {
        weui.toast('收藏成功', 600);
        let goods_id = $(this).attr('goods_id');
        //ajax请求后台关注,并提示关注成功
        $.ajax({
            type: "POST",
            url: "collects/collect",
            data:{
                'goods_id' : goods_id
            },
            success: function(msg){

            },
            error: function (error) { //200以外的状态码走这里
                console.log(error.responseJSON);
            }
        });
    });
</script>
@yield('js')
</body>
</html>