
        $('#historyPageGo').click(function(){
            //console.log(window.history.go(-1));
            window.history.go(-1);//返回上一页
            //console.log('window.history.go(-1)')
        });

        //价钱小数点之后字体变小
        var price = $('.price-decimal-point');
        for(var i=0; i<price.length; i++){
            var s = price.eq(i).text().replace(/\.([\d\.]*)/,'<span style="font-size:.8rem;">.'+'$1'+'</span>');
            price.eq(i).html('<i class="fa fa-rmb"></i>'+s);
        }
        //已完成提示
        function toast(msg = '已完成'){
            msg = msg || '已完成';
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

