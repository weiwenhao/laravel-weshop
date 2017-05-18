@extends('post.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <post post_id="{{ $post_id }}"></post>
@stop
@section('js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop