<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    {{--ajaxtoken--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>home</title>
    <!-- 以下是公共css -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/plugins/weui.css"/>
    <link rel="stylesheet" href="/css/common.css"/>

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
{{--公共js--}}
<script src="/plugins/img_load_echo.min.js"></script> {{--图片懒加载--}}
<script src="/js/app.js"></script>
<script src="/js/common.js"></script>
<script>
    $.ajaxSetup({ //这段话的意思使用ajax,会将csrf加入请求头中
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
</body>
</html>