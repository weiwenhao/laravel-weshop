@extends('post.layout')
@section('css')
<style>

</style>
@stop
@section('content')
<create-post></create-post>
@stop
@section('js')
<script type="text/javascript" class="uploader js_show">
    //选择类型**************
    var a = $('#selectType i');
    var aType = $('.poster-bottom > div');
    a.click(function(){
        for(var i=0;  i<aType.length; i++){
            a.eq(i).css('color','#aaa');
            aType.eq(i).css('display','none')
        }
        $(this).css('color','#f90');
        aType.eq($(this).data().val).css('display','block')
    });
</script>
@stop