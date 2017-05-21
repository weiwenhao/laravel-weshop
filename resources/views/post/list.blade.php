@extends('post.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <posts></posts>
@stop
@section('js')
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop