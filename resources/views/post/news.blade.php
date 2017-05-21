@extends('post.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <post-news></post-news>
@stop
@section('js')
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop