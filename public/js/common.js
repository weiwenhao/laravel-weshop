   
$(function(){
        
        //价钱小数点之后字体变小
        var price = $('.price-decimal-point');
        for(var i=0; i<price.length; i++){
            var s = price.eq(i).text().replace(/\.([\d\.]*)/,'<span style="font-size:.9rem;letter-spacing:-1px;">.'+'$1'+'</span>');
            price.eq(i).html('<i class="icon icon-money"></i>'+s);
        }
        $('#historyPageGo').click(function(){
            window.history.go(-1);//返回上一页
        });
        $('#previous_page').click(function(){
            window.history.go(-1);//返回上一页
        });
        $('#previous_f5').click(function(){
            window.location.href = document.referrer;//返回上一页并刷新
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
            if( num > $(this).prev().data().max )return;//不能小于data-max
            $(this).prev().val( num );
        });
        $(".min").click(function() {
            var num = parseInt($(this).next().val())-1;
            if(num<1)return;//不能小于1
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

//添加 class="off-number" 出现已售罄 ************************************
var yishouqing = '<div class="off"><!--已售罄-->\
                    <i class="icon icon-yishouqing"><!--已售罄--></i>\
                </div>';
$('.off-number').before(yishouqing);
//添加 class="off-sale" 出现下架
var yixiajia = '<div class="off"><!--已下架-->\
                    <i class="icon icon-yixiajia"><!--已下架--></i>\
                </div>';
$('.off-sale').before(yixiajia);
    