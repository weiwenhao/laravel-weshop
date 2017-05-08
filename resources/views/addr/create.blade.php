@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/me.css"/>
    <link rel="stylesheet" href="/css/address.css"/>
<style>

</style>
@stop
@section('content')
    <!--top-->
    <div class="me-header-top">
        <div>
            <a id="historyPageGo"><span class="fa fa-chevron-left fa-lg"></span></a>
        </div>
        <div>添加地址</div>
        <div></div>
    </div>
    <!--姓名-->
    <div class="height-2rem"></div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">姓名:</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text"  placeholder="姓名" id="name">
        </div>
    </div>
    <!--电话-->
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">电话:</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" placeholder="手机号码" id="phone">
        </div>
    </div>
    <div class="weui-cell__bd"><p>收货地址</p></div>
    <!--什么园-->
    <div class="page">
        <div class="page__bd page__bd_spacing">
            <a class="weui-btn weui-btn_default" id="garden">请选择</a>
            <a class="weui-btn weui-btn_default" id="floor">请选择</a>
        </div>
        <div class="weui-cell" id="qiTa"><!--其他地址-->
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="请输入其他地址">
            </div>
        </div>
        <div class="weui-skin_android" id="androidActionsheet" style="display: none">
            <div class="weui-mask"></div>
            <div class="weui-actionsheet">
                <div class="weui-cells weui-cells_checkbox">
                    <label class="weui-cell weui-check__label" for="x2">
                        <div class="weui-cell__hd">
                            <input type="radio" class="weui-check" name="radio2" id="x2" checked="checked"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>春晖园</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x3">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x3"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>图强园</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x4">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x4"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>积胜园</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x5">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x5"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>弘毅园</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x6">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x6"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>至善园</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x7">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x7"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>思贤园</p></div>
                    </label>
                  {{--  <label class="weui-cell weui-check__label" for="x8">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio2" class="weui-check" id="x8"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>其他</p></div>
                    </label>--}}
                </div>
            </div>
        </div>
        <!--第二列选项-->
        <div class="weui-skin_android" id="androidActionsheet2" style="display: none">
            <div class="weui-mask"></div>
            <div class="weui-actionsheet">
                <div class="weui-cells weui-cells_checkbox">
                    <label class="weui-cell weui-check__label" for="x8">
                        <div class="weui-cell__hd">
                            <input type="radio" class="weui-check" name="radio3" id="x8" checked="checked"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>梅香楼</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x9">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio3" class="weui-check" id="x9"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>兰洁楼</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x10">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio3" class="weui-check" id="x10"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>菊清楼</p></div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__hd">
                            <input type="radio" name="radio3" class="weui-check" id="x11"/><i class="weui-icon-checked"></i>
                        </div>
                        <div class="weui-cell__bd"><p>竹贞楼</p></div>
                    </label>
                </div>
                <!--/div-->
            </div>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">门牌号:</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number"  placeholder="门牌号码" id="room">
        </div>
    </div>

    <div class="weui-cells weui-cells_checkbox" >
        <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__hd">
                <input type="checkbox" class="weui-check" name="radio1" id="c1" />
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>设置为默认地址</p>
            </div>
        </label>
    </div>
    <a href="javascript:void(0);" name="sub" class="weui-btn weui-btn_primary new-address">确定添加地址</a>
@stop
@section('js')
    <script type="text/javascript" src="/js/address.js"> </script>
<script>
	
</script>
@stop