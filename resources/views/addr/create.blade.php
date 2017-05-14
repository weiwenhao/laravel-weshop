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
            <a id="previous_page"><span class="fa fa-chevron-left fa-lg"></span></a>
        </div>
        <div>添加地址</div>
        <div></div>
    </div>
    <form action="#" method="post">
        <!--姓名-->
        <div class="height-2rem"></div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">姓&nbsp;&nbsp;&nbsp;名:</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text"  placeholder="姓名" id="name" required>
            </div>
        </div>
        <!--电话-->
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">电&nbsp;&nbsp;&nbsp;话:</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number" placeholder="手机号码" id="phone" required>
            </div>
        </div>
        <div class="weui-cell__bd"><p>收货地址</p></div>
        <!--什么园-->
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">地&nbsp;&nbsp;&nbsp;址:</label>
            </div>
            <div class="weui-cell__bd">
                <select name="shaixuan" id="floor_name" class="weui-select">
                    <option value="">请选择</option>
                    <option value='梅香楼'>梅香楼</option>
                    <option value='兰洁楼'>兰洁楼</option>
                    <option value='菊清楼'>菊清楼</option>
                    <option value='竹贞楼'>竹贞楼</option>

                    <option value='诚敬楼'>诚敬楼</option>
                    <option value='恭谦楼'>恭谦楼</option>
                    <option value='谨信楼'>谨信楼</option>
                    <option value='勤勉楼'>勤勉楼</option>

                    <option value='孝悌楼'>孝悌楼</option>
                    <option value='三省楼'>三省楼</option>
                    <option value='友谅楼'>友谅楼</option>
                    <option value='互荣楼'>互荣楼</option>

                    <option value='明得楼'>明得楼</option>
                    <option value='明志楼'>明志楼</option>

                    <option value='日善楼'>日善楼</option>
                    <option value='兼善楼'>兼善楼</option>

                    <option value='思勉楼'>思勉楼</option>
                    <option value='思齐楼'>思齐楼</option>


                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">门牌号:</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number"  placeholder="门牌号码" id="number" required>
            </div>
        </div>

        <div class="weui-cells weui-cells_checkbox" >
            <label class="weui-cell weui-check__label" for="c1">
                <div class="weui-cell__hd">
                    <input type="checkbox" class="weui-check" name="is_default" value="1" id="c1" />
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>设置为默认地址</p>
                </div>
            </label>
        </div>
        <button {{--href="javascript:void(0);"--}} type="submit" class="weui-btn weui-btn_primary new-address">确定添加地址</button>
    </form>
@stop
@section('js')
<script>
    $('[type=submit]').click(function (event) {
        event.preventDefault();
        let name = $('#name').val();
        let phone = $('#phone').val();
        let floor_name = $('#floor_name option:selected').val();
        let number = $('#number').val();
        let is_default = $('input[name=is_default]:checked').val()?1:0;
        $.ajax({
            type: "POST",
            url: "/addrs",
            data:{
                'name' : name,
                'phone' : phone,
                'floor_name' : floor_name,
                'number' : number,
                'is_default' : is_default,
            },
            success: function(msg){
                toast('添加成功');
                //返回上一页
                window.location.href = document.referrer;//返回上一页并刷新
            },
            error: function (error) { //200以外的状态码走这里
                let err = error.responseJSON;
                let msg = '';
                if(err.name){
                    msg += err.name[0]+'\n';
                }
                if(err.phone){
                    msg += err.phone[0]+'\n';
                }

                if(err.floor_name){
                    msg += err.floor_name[0]+'\n';
                }
                if(err.number){
                    msg += err.number[0]+'\n';
                }
                if(err.is_default){
                    msg += err.is_default[0]+'\n';
                }
                alert(msg);

            }
        });
    });
    
</script>
@stop