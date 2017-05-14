@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/address.css"/>
    <style>

    </style>
@stop
@section('content')
    <!--顶部-->
    <div class="me-header-top">
        <div><a href="{{ session('addrs_previous_url', url()->previous())  }}"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>我的收货地址</div>
        <div></div>
    </div>
    <!--收货地址-->
    <div class="height-2rem"></div>
    @foreach($addrs as $addr)
        <div class="container me-address">
            <div class="row address">
                @if($addr->is_default)
                    <i class="icon icon-moren"><!--默认地址图标--></i>
                @endif
                <a href="" class="del-addr" addr_id="{{ $addr->id }}">
                    <div class="col-xs-1 me-a showIOSDialog1">
                        <i class="fa fa-times-circle-o fa-lg"></i>
                    </div>
                </a>
                <a href="{{ url('addrs/'.$addr->id.'/edit') }}">
                    <div class="col-xs-10 " >
                        <p>收货人:<b>{{ $addr->name }}</b> <tt>{{ $addr->phone }}</tt></p>
                        <p>惠州市技师学院，{{ $addr->floor_name }}，{{ $addr->number }}</p>
                    </div>
                    <div class="col-xs-1 me-a" name="addressGo">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
    <div class="weshop-center-block" style="display:{{ $addrs->toArray()?'none':'block' }}">
        <span class="fa fa-map-marker fa-5x"></span>
        <h3>╮(￣▽￣")╭</h3>
    </div>

    <a class="weui-btn weui-btn_primary new-address"  href="{{ url('addrs/create') }}">新增收货地址</a>
@stop
@section('js')
    <script type="text/javascript" src="/js/shopping_car.js"></script>
    <script>
        $('.del-addr').click(function (event) {
            event.preventDefault();
            let addr_id = $(this).attr('addr_id');
            if(!addr_id){
                alert('系统错误,请联系客服');
                return;
            }
            if(confirm('你确定要删除该收获地址吗？')){
                $.ajax({
                	type: "DELETE",
                	url: "/addrs/"+addr_id,
                	success: function(msg){
                	    toast('删除成功');
                        location.reload()
                	},
                	error: function (error) { //200系列以外的状态码走这里
                		if(error.status == 403){
                		    alert('系统错误,请联系客服');
                        }
                	}
                });
            }
        });
    </script>
@stop