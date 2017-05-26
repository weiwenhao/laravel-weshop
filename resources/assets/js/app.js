window._ = require('lodash');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.$ = window.jQuery = require('jquery');

//懒加载*****
function echo() {
    var img = $('img');
    var aImg = [];
    for(var i=0,j=0; i<img.length; i++){
        if( img.eq(i).attr('data-img') ){
            aImg[j++] = img[i];//.attr('data-img');
        }
    }
    window.onscroll = ScrollTop;
    function ScrollTop(){/*滚动触发,上下滑动*/
        for(var i=0; i<aImg.length; i++){
            var top = [];
            top[i] = $(aImg[0]).offset().top - window.pageYOffset;
            //window.innerHeight-50图片距顶部多少像素就加载
            if( top[i] < (window.innerHeight-50) && top[i] > 0){
                aImg[i].src = $(aImg[0]).data('img');
                $(aImg[0]).addClass('fade-in');
                aImg.splice(i,1);//加载完清除
                i--;
            }
        }
    }ScrollTop();
}
echo();



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


//弹出菜单***
var $actionsheet = $('#actionsheet');
var $iosMask = $('#iosMask');
function hideActionSheet() {//关闭
    $actionsheet.css({'-webkit-transform': 'translate3d(0,102%,0)','transform': 'translate3d(0,102%,0)'});
    $iosMask.css('display','none');
}
$iosMask.on('click', hideActionSheet);
$('#iosActionsheetCancel').on('click', hideActionSheet);
$(".showIOSActionSheet").on("click", function(){//显示
    $actionsheet.css({'-webkit-transform': 'translate(0)','transform': 'translate(0)'});
    $iosMask.css('display','block');
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


//选择类型******************************
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

Vue.component('GoodsComments', require('./components/goods/GoodsComments.vue'));

/*const app = new Vue({
    el: '#app',
});*/
