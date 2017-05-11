 //购物车
$(function(){
    //编辑 对象 (json)
    var edit = {
        on : $('#me_edit'),//编辑全部按钮
        listNum : $('#shoppingList .me-edit input'),//编辑列表数量
        list : $('#shoppingList .me-edit'),//+-编辑
        jie : $('#bill .row .col-xs-4'),
        select : $('[name="select"]','#shoppingList'),//选中商品 列表
        selectAll : $('[name="selectAll"]','#bill .row'),//全选按钮
        deleteAll : $('[name="deleteAll"]'),//删除 全部
        checkbox : $('.me-checkbox-icon'),//按钮
        price : $('#shoppingList .col-xs-2'),
        row : $('#shoppingList .row'),
        selectList:[],//选中列表
        offList : [],//下架列表
        update : function(){
            this.listNum = $('#shoppingList .me-edit input');//编辑列表数量
            this.list = $('#shoppingList .me-edit');//+-编辑
            this.jie = $('#bill .row .col-xs-4');
            this.select = $('[name="select"]','#shoppingList');
            this.price = $('#shoppingList .col-xs-2');
            this.row = $('#shoppingList .row');
            shoppCar.update();
        },
        selected : function(){//按钮选中
            this.select = $('[name="select"]','#shoppingList');
            var i=0,num=0;
            for(; i<this.select.length; i++){
                if(this.select[i].checked){
                    num++;
                    this.selectList[i] = true;
                }else{this.selectList[i] = false;}
            };return num;
        },
        offListF : function(){//下架列表
            for(var i=0; i<this.select.length; i++){
                if(this.select.eq(i).parents().parents().prev().is('[class="off"]')){
                    this.offList[i] = false;
                }else{this.offList[i] = true;}
            }
        },
        ifDelete : function(){//判断删除
            if(this.selected() == 0 || $('.center-block .fa-shopping-cart').parents().css('display')=='block' ){
                this.deleteAll.css('background','#eee');
                this.deleteAll.off('click');

            }else{
                this.deleteAll.css('background','rgb(230, 67, 64)');
                this.deleteAll.on('click', function(){
                    $('#iosDialog1').fadeIn(200);
                });
                this.deleteAll.click(deleteAll);
            }
        }
    };
    edit.offListF();

    //删除 按钮
    edit.deleteAll.click(deleteAll);
    function deleteAll(){
        edit.update();//更新
        edit.selected();//选中列表
        $('#okDelete').click(function(){//确认删除
            edit.selected();//选中列表
            edit.update();//更新
            for(var i in edit.selectList){
                if( edit.selectList[i] ){
                    edit.row.eq(i).remove();
                }
            }
            //ajax删除后台数据
            ajaxDel();
            edit.ifDelete();//判断删除
            edit.row = $('#shoppingList .row');
            if(edit.row.length == 0){//购物车
                $('.center-block .fa-shopping-cart').parents().css('display','block');
            }
           
        });
    }
    //编辑 商品
    edit.on.click(function(){//点击编辑时
        var RMBnum = shoppCar.numList;//商品列表数量
        if(edit.on.text() == '编辑'){
            edit.ifDelete();//判断删除
             //获取 商品 数量
            for(var i=0; i<RMBnum.length; i++){
                edit.listNum[i].value = RMBnum[i].innerText ;
                edit.list[i].style.display='block';//显示编辑
                edit.checkbox.eq(i).css('z-index','10');//按钮Z轴
                edit.price[i].style.visibility = 'hidden';
            }
            //结算显示隐藏
            edit.jie[1].style.display = 'none';
            edit.jie[2].style.display = 'none';
            edit.jie[3].style.display = 'block';
            edit.jie[4].style.display = 'block';
            edit.on.text('完成');
        }else{//编辑完成
            edit.update();//更新
            edit.offListF();//下架列表
            edit.ifDelete();//判断删除
            for(var i=0; i<edit.list.length; i++){
                edit.list[i].style.display='none';//隐藏编辑
                RMBnum[i].innerText = $('input',edit.list[i]).val();//编辑完成给商品赋值
                edit.price[i].style.visibility = 'visible';
                edit.checkbox.eq(i).css('z-index','1');//按钮Z轴
                if( !edit.offList[i] ){
                   edit.select[i].checked=false;
                }
            }
            //结算显示隐藏
            edit.jie[1].style.display = 'block';
            edit.jie[2].style.display = 'block';
            edit.jie[3].style.display = 'none';
            edit.jie[4].style.display = 'none';
            
            shoppCar.HeJi();//合计方法
            shoppCar.Jie();//结算方法
            edit.on.text('编辑');
        }
    });
    //选中商品
    edit.select.click(function(){
        if( $(this).is(':checked') && edit.select.length==edit.selected() ){
            edit.selectAll[0].checked = true;
        }else{ edit.selectAll[0].checked = false; }
        edit.ifDelete();//是否删除
        shoppCar.HeJi();//合计
        shoppCar.Jie();//结算方法
    });   
    // + - 编辑商品 
    $(".edit-add").click(function() {
        var num = parseInt($(this).prev().val()) + 1;
        if( num>$(this).prev().data().max )
            return;//不能小于data-max
        $(this).prev().val( num );
        // $(this).prev().val( parseInt($(this).prev().val()) + 1 );
    });
    $(".edit-min").click(function() {
        var num = parseInt($(this).next().val())-1;
        if(num<1)return;//不能小于1
        $(this).next().val( num );
    });

    var shoppCar = {//购物车对象
        rmbList : $('#shoppingList .row .RMBnum > span'),//商品列表价钱
        numList : $('#shoppingList .row .RMBnum tt'),//商品列表数量
        heji : $('#bill .row').eq(0).find('tt'),//合计
        jie : $('#bill [name="num"] a'),//结算
        //结算方法
        Jie : function(){
            var num = 0;//结算数量
            for(var i=0; i<edit.select.length; i++){//edit.select.length
                if( edit.select.eq(i).is(':checked') ){
                    num+=1;
                }
            }
            if(num==0){//结算按钮背景
                this.jie.css('background','#ccc');
            }else{
                this.jie.css('background','#e64340');
            };
            this.jie.find('span').text(num);//结算数量
        },
        //合计方法
        HeJi : function(){
            var num=0;
            var arr = this.aShoppRMB();
            var arrNum = this.aShoppNum();
            for(var i=0; i<arr.length; i++){
                if( edit.select.eq(i).is(':checked') ){
                    num += arr[i]*arrNum[i];//价钱*数量
                }
            }
            num = num.toFixed(2);//小数点保留两位
            this.heji.text(num);//合计
        },
        //R 商品 价钱 列表
        aShoppRMB : function(){
            var aList = [];
            for(var i=0; i<this.rmbList.length; i++){
               aList[i] = parseFloat( this.rmbList[i].innerText ) ;//转浮点数
            };return aList;
        },
        //R 商品 数量 列表
        aShoppNum : function(){
            var aList = [];
            for(var i=0; i<this.numList.length; i++){
               aList[i] = parseInt( this.numList[i].innerText );//转整数数
            };return aList;
        },
        update : function(){//更新
            this.rmbList = $('#shoppingList .row .RMBnum > span');//商品列表价钱
            this.numList = $('#shoppingList .row .RMBnum tt');
        }
    }
    //全选按钮
    edit.selectAll.click(selectAll);
    function selectAll(){
        var len = edit.select.length;//多少个input;
        if(edit.selectAll.is(':checked')){
            for(var i=0; i<len; i++){
                if(edit.offList[i]){//匹配下架列表
                    edit.select[i].checked = true;
                    edit.selectList[i] = true;
                }
            }
        }else{
            for(var i=len-1; i>=0; --i){
                edit.select[i].checked = false;
            }
        }
        edit.ifDelete();
        shoppCar.Jie();//结算方法
        shoppCar.HeJi();//合计
    }
    /*初始化*/
    edit.ifDelete();//是否删除
    shoppCar.Jie();//结算方法
    
});

    var sub = $('#sub');//0不结算
    sub.click(function(){
        if( $('span',this).text() > 0 ){
            return true;
        }return false;
    });
     //点按钮关闭
    $('#dialogs').on('click', '.weui-dialog__btn', function(){
        $(this).parents('.js_dialog').fadeOut(200);//关闭
    });