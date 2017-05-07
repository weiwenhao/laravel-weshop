
//购物车 提交订单
  $(function(){
    var shoppCar = {//购物车对象
        select : $('[name="select"]','#shoppingList'),//选中商品 列表
        shoppListRMB : $('#shoppingList .row .RMBnum span'),//商品列表价钱
        shoppListNum : $('#shoppingList .row .RMBnum tt'),//商品列表数量
        heji : $('#bill .row').eq(0).find('tt'),//合计
        //合计方法
        HeJi : function(){
            var num=0;
            var arr = this.aShoppRMB();
            var arrNum = this.aShoppNum();
            for(var i=0; i<arr.length; i++){
                if( this.select.eq(i).is(':checked') ){
                    num += arr[i]*arrNum[i];//价钱*数量
                }
            }
            num = num.toFixed(2);//小数点保留两位
            this.heji.text(num);//合计
        },
        //R 商品 价钱 列表
        aShoppRMB : function(){
            var aList = [];
            for(var i=0; i<this.shoppListRMB.length; i++){
               aList[i] = parseFloat( this.shoppListRMB[i].innerText ) ;//转浮点数
            };return aList;
        },
        //R 商品 数量 列表
        aShoppNum : function(){
            var aList = [];
            for(var i=0; i<this.shoppListNum.length; i++){
               aList[i] = parseInt( this.shoppListNum[i].innerText );//转整数数
            };return aList;
        }
    }
    shoppCar.HeJi();//合计方法

    setTimeout(function(){//过期
            var sub = $('#sub');
            sub.text('以过期');
            sub.css({'background':'#eee','color':'#444'});
            sub.on('click',function(){
                return false;
            });
    },1000*60);
    $('#bill .row').css('bottom','0');
});
