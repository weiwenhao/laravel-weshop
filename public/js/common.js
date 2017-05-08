   
$(function(){
        
        //价钱小数点之后字体变小
        var price = $('.price-decimal-point');
        for(var i=0; i<price.length; i++){
            var s = price.eq(i).text().replace(/\.([\d\.]*)/,'<span style="font-size:.9rem;letter-spacing:-1px;">.'+'$1'+'</span>');
            price.eq(i).html('<i class="fa fa-rmb"></i>'+s);
        }
        $('#previous_page').click(function(){
            window.history.go(-1);//返回上一页
        });
        //弹出菜单
        var $actionsheet = $('#actionsheet');
        var $iosMask = $('#iosMask');
        function hideActionSheet() {//关闭
            $actionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
            $('body').css('overflow','visible');//关闭时 恢复
        }
        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', hideActionSheet);
        $(".showIOSActionSheet").on("click", function(){//显示
            $actionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
            $('body').css('overflow','hidden');//显示时 不能移动滚动条
        });
        //编辑商品
        var p = $('.price span').text();
        p=parseFloat(p);
        p=p.toFixed(2);//小数点保留两位
        function prices(n){
            var p2=p*n;
            p2=p2.toFixed(2);//小数点保留两位
            $('.price span').text(p2);
        }
        $(".add").click(function() {
            var num = parseInt($(this).prev().val()) + 1;
            prices(num);
            $(this).prev().val(num);
        });
        $(".min").click(function() {
            var num = parseInt($(this).next().val())-1;
            if(num<1)return;//不能小于1
            prices(num);
            $(this).next().val(num);
        });
        //选择类型
//******************************
        var target = $('.class-ok .attr-target');
        var input = $('.attr-value');
        input.click(selectAttr);
        function selectAttr(){
            var s = '';
            $('.attr-value:checked').each(function(index,elem){
                s += $(this).next().text()+', ';
            });
            s=s.replace(/, +$/,'');
            target.text(s);
        }selectAttr();
        

        //图片懒加载
        if(typeof Echo == 'object'){
            Echo.init({
                offset: 600,//离可视区域多少像素的图片可以被加载
        　　  throttle: 300 //图片延时多少毫秒加载
            }); 
        }
        
});
//添加 class="off-sale" 出现已下架 ************************************
var html = '<div class="off"><!--已下架-->\
                <i class="icon icon-xiajia"><!--已下架--></i>\
            </div>';
        $('.off-sale').before(html);
//已完成提示************************************
        function toast( msg ){
            msg = msg || '已完成' ;
            var toast = '<div id="toast">\
                <div class="weui-mask_transparent"></div>\
                 <div class="weui-toast">\
                 <i class="weui-icon-success-no-circle weui-icon_toast"></i>\
                 <p class="weui-toast__content">'+msg+'</p>\
                 </div>\
                 </div>';

            if(!$('#toast').length){
                $('body').append(toast);
            }else{
                $('#toast.weui_toast_content').html(msg);
            }   
            $('#toast').fadeIn('fast',function(){
                setTimeout(function(){
                    $('#toast').fadeOut('fast');
                },800);
            });
        }
//加载中提示************************************
        var oWait = $('.fa-comments-o','.weui-tabbar');
        oWait.click(function(){wait();});
        function wait(s){
            var s = s || '程序猿小哥正在努力开发中';
            var wait = '<div id="loadingToast2" style="position:fixed;z-index:10;">\
                    <div class="weui-mask_transparent"></div>\
                    <div class="weui-toast">\
                        <i class="weui-loading weui-icon_toast"></i>\
                        <p class="weui-toast__content">'+s+'</p>\
                    </div>\
                </div>';
            if(!$('#loadingToast2').length){
                $('body').append(wait);
            }else{
                $('#loadingToast2.weui_toast_content').html(wait);
            }
            $('#loadingToast2').fadeIn('fast',function(){
                setTimeout(function(){
                    $('#loadingToast2').fadeOut('fast');
                },1500);
            });
        };
    //确定取消 ******************************************************
        function weConfirm(msg,okId,noId){
        msg = msg || '确定吗';
        var weConfirmOk = okId || 'weConfirmOk';
        var weConfirmNo = noId || 'weConfirmNo';
        var html = '<div id="dialogs">\
            <div class="js_dialog" id="iosDialog1" style="display: ">\
                <div class="weui-mask"></div>\
                <div class="weui-dialog">\
                    <div class="weui-dialog__hd"><strong class="weui-dialog__title">'+msg+'</strong></div>\
                    <div class="weui-dialog__ft">\
                        <a id="'+weConfirmOk+'" class="weui-dialog__btn weui-cell_warn me-font-f90">确定</a>\
                        <a id="'+weConfirmNo+'" class="weui-dialog__btn weui-dialog__btn_primary">取消</a>\
                    </div>\
                </div>\
            </div>\
        </div>';
        if(!$('#dialogs').length){
            $('.weui-tabbar').after(html);
        }
        $('#iosDialog1').fadeIn(200);
        
        $('#'+weConfirmOk+'').bind('click',function(){console.log('ok'); return true});
        $('#'+weConfirmNo+'').bind('click',function(){console.log('no'); return false});
        //点按钮关闭
        $('#dialogs').on('click', '.weui-dialog__btn', function(){
            $(this).parents('.js_dialog').fadeOut(200);//关闭
        });
    }
    