@extends('circle.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <circles></circles>
@stop
@section('js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({!! $js->config(['previewImage'], false) !!});
    </script>
@stop