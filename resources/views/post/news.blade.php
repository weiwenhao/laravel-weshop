@extends('post.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <post-news></post-news>
@stop
@section('js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop