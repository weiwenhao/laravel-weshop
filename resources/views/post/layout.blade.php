<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    {{--ajaxtoken--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>天哪-校园圈子</title>
    <!-- 以下是公共css -->
    <link rel="stylesheet" href="/plugins/weui.css"/>
    <link rel="stylesheet" href="/css/circle.css"/>
    <title>校园圈子</title>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('css')
</head>
<body>
<div id="app">
    @yield('content')
</div>
{{--wui.js--}}
<script type="text/javascript" src="https://res.wx.qq.com/open/libs/weuijs/1.1.1/weui.min.js"></script>
{{--jssdk--}}
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/circle.js"></script>
@yield('js')
</body>
</html>