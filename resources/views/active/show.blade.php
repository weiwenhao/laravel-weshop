@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
    <style>
        .active-info {
            background-color: white;
        }
    </style>
@stop
@section('content')
    <div class="me-header-top">
        <div><a href="/"><span class="icon icon-back icon-lg"></span></a></div>
        <div>{{ $active->name }}</div>
        <div></div>
    </div>
    <div style="height: 2rem"></div>
    <div  class="active-info">
        {!! $active->content !!}
    </div>
@stop
@section('js')
    <script>
        $('.active-info').find('img').css('height', 'auto')
        $('.active-info').find('img').css('width', '100%')
    </script>
@stop