@extends('post.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <post post_id="{{ $post_id }}"></post>
@stop
@section('js')
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop