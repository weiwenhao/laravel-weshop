@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/food_info.css"/>
<style>
</style>
@stop
@section('content')
    <!--**************** 顶部 ********************-->
    <div class="me-header-top me-header-food-info"><!--m-->
        <div><a href="{{ url('orders/no_comment') }}"><span class="icon icon-back icon-lg"></span></a></div>
        <div >
            晒单评价
        </div>
        <div></div>
    </div>
    <div style="height:1.8rem;"></div>
    <div class="assess-star weui-cell">
        <div class="assess-img weui-cell__hd">
            <img src="{{ $order_goods->sm_image }}">
        </div>
        <input id="starCount" value="0" style="display: none"><!--评分数量-->
        <div class="star weui-cell__bd">
            <h4>评分</h4>
            <i class="icon icon-favor"></i>
            <i class="icon icon-favor"></i>
            <i class="icon icon-favor"></i>
            <i class="icon icon-favor"></i>
            <i class="icon icon-favor"></i>
        </div>
    </div>
    <hr>
    <div class="poster-text-body">
        <textarea class="text" id="poster" placeholder="您的评价对我们至关重要~" spellcheck="false"></textarea>
    </div>
    <div class="poster-body">
        <div class="poster-bottom">
            <div class="weui-cells weui-cells_form" id="uploaderCustom">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__hd">
                                <p class="weui-uploader__title">图片上传</p>
                                <div class="weui-uploader__info"><span id="uploadCount">0</span>/3</div>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderCustomFiles"></ul>
                                <div class="weui-uploader__input-box">
                                    <input id="uploaderCustomInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--占位--}}
    <div class="height-4rem"></div>
    <a class="weui-btn weui-btn_primary sub-assess btn-green-c" href="javascript:void(0)">提交</a>
@stop
@section('js')
<script>
    var goods_comment_id = null;
    /**
     * ajax提交表单
     */
    $('.sub-assess').click(function (event) {
        event.preventDefault();
        let content = $('#poster').val();
        let level = $('#starCount').val();
        if(level == 0){
            weui.alert('打个分吧');
            return
        }
        if(content == ''){
            weui.alert('您还没有评论呢');
            return
        }

        let loading = weui.loading('请稍等');
        setTimeout(function () { //如果超过5秒钟没有响应则自动关闭loading框,并提示一个超时响应
            loading.hide(function() {
                weui.topTips('请求超时', 3000);
            });
        }, 10000);

        $.ajax({
        	type: "POST",
        	url: "/goods_comments/{{ $order_goods->id }}",
        	data:{
        	    'content' : content,
                'level' : level
            },
        	success: function(msg){
                goods_comment_id = msg;
                uploadCustomFileList.forEach(function(file){
                    file.upload();
                });
                //关闭弹出层
                loading.hide(function () {
                    weui.toast('评价成功');
                });
                //返回订单列表页
                location.href = '{{ url('orders') }}';
        	},
        	error: function (error) { //200以外的状态码走这里
                //关闭弹出层
                loading.hide();
                if(error.status == 404){
                    weui.alert(error.responseText);
                }
        	}
        });
    })

    var uploadCustomFileList = [];
    var uploadCount = 0;
    var uploadCountDom = document.getElementById("uploadCount");
    weui.uploader('#uploaderCustom', {
        url: 'http://' + location.hostname + '/goods_comments/upload',
        auto: false, //不开启自动上传,手动触发上传
        type: 'file',
        fileVal :'goods_comment_img',
        compress: {
            width: 1600,
            height: 1600,
            quality: .6
        },
        onBeforeQueued: function(files) {
            if(["image/jpg", "image/jpeg", "image/png", "image/gif"].indexOf(this.type) < 0){
                weui.alert('请上传图片');
                return false;
            }
            if(this.size > 10 * 1024 * 1024){
                weui.alert('请上传不超过10M的图片');
                return false;
            }
            if (files.length > 3) { // 防止一下子选中过多文件
                weui.alert('最多只能上传3张图片，请重新选择');
                return false;
            }
            if (uploadCount + 1 > 3) {
                weui.alert('最多只能上传3张图片');
                return false;
            }

            ++uploadCount;
            uploadCountDom.innerHTML = uploadCount;
        },
        onQueued: function(){
            uploadCustomFileList.push(this);
        },
        onBeforeSend: function(data, headers){ //文件上传前调用
            $.extend(data, { 'goods_comment_id' : goods_comment_id }); // 可以扩展此对象来控制上传参数
            $.extend(headers, { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }); // 可以扩展此对象来控制上传头部
        },
    });

    document.querySelector('#uploaderCustomFiles').addEventListener('click', function(e){
        var target = e.target;

        while(!target.classList.contains('weui-uploader__file') && target){
            target = target.parentNode;
        }
        if(!target) return;

        var url = target.getAttribute('style') || '';
        var id = target.getAttribute('data-id');

        if(url){
            url = url.match(/url\((.*?)\)/)[1].replace(/"/g, '');
        }
        var gallery = weui.gallery(url, {
            onDelete: function(){
                weui.confirm('确定删除该图片？', function(){
                    var index;
                    for (var i = 0, len = uploadCustomFileList.length; i < len; ++i) {
                        var file = uploadCustomFileList[i];
                        if(file.id == id){
                            index = i;
                            break;
                        }
                    }
                    if(index) uploadCustomFileList.splice(index, 1);

                    target.remove();
                    gallery.hide();
                });
            }
        });
    });

    function submitAssess(){//星星评分
        var star = $('.assess-star .star .icon');
        var starCount = $('#starCount');
        star.click(function(){
            for(var i=0; i<star.length; i++){
                star.eq(i).removeClass('icon-favorfill');
                star.eq(i).addClass('icon-favor');
            }
            for(var i=0; i<$(this).index(); i++){
                star.eq(i).removeClass('icon-favor');
                star.eq(i).addClass('icon-favorfill');
            }
            starCount.val( $(this).index() );
        });
    };submitAssess();
</script>
@stop