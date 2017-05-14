var yuan = {
        "春晖园":["梅香楼","兰洁楼","菊清楼","竹贞楼"],
        "图强园":["成敬楼","恭虚楼","谨信楼","勤勉楼"],
        "积胜园":["梅香楼","兰洁楼","菊清楼","竹贞楼"],
        "弘毅园":["明志楼","明德楼"],
        "至善园":["日善楼","兼善楼"],
        "思贤园":["思勉楼","思齐楼"],
        "其他":["其他"]
    }
    $('#location').click(function(){//点击地址跳转  
        window.location.href = 'address.html';
    });
    $('[name="addressGo"]').click(function(){//点击地址跳转  
        window.location.href='address.html';
    });
    //showIOSDialog1
    $(function(){
        //第一个列表
        var $androidActionSheet = $('#androidActionsheet');
        var $androidMask = $androidActionSheet.find('.weui-mask');

        $("#garden").on('click', function(){
            $androidActionSheet.fadeIn(50);//显示
            $androidMask.on('click',function () {
                $androidActionSheet.fadeOut(200);//关闭
            });
            $androidActionSheet.find('.weui-check__label').click(function(){//点击列表
                var y = $('p',this).text();//当前选中的是哪个园
                var html = '';
                $androidActionSheet.fadeOut(200);//关闭
                $("#garden").text(y);//选中当前园后添加
                html += '<label class="weui-cell weui-check__label" for="x8"><div class="weui-cell__hd"><input type="radio" class="weui-check" name="radio3" id="x8" checked="checked"/><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+yuan[y][0]+'</p></div></label>';//添加第一个
                for(var i=1; i<yuan[y].length; i++){
                    html += '<label class="weui-cell weui-check__label" for="x'+i+9+'"><div class="weui-cell__hd"><input type="radio" name="radio3" class="weui-check" id="x'+i+9+'"/><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+yuan[y][i]+'</p></div></label>';
                }
                //console.log(html);
                $('#androidActionsheet2 .weui-cells_checkbox').html(html);//全部添加
                $("#floor").text(yuan[y][0]);//添加第二个
                if($('p',this).text()=='其他'){
                    $('#qiTa').css('display','block');
                }else{
                    $('#qiTa').css('display','none');
                }
            });
        });
        //第二个列表
        var $androidActionSheet2 = $('#androidActionsheet2');
        var $androidMask2 = $androidActionSheet2.find('.weui-mask');
        $("#floor").on('click', function(){
            $androidActionSheet2.fadeIn(50);//显示
            $androidMask2.on('click',function () {
                $androidActionSheet2.fadeOut(200);//关闭
            });
            $androidActionSheet2.find('.weui-check__label').click(function(){
                $androidActionSheet2.fadeOut(200);//关闭
                $("#floor").text($('p',this).text());//选中当前园后添加
            });
            
        });
        //点击显示
        $('.showIOSDialog1').on('click', function(){
            $('#iosDialog1').fadeIn(200);
        });
        //点按钮关闭
        $('#dialogs').on('click', '.weui-dialog__btn', function(){
            $(this).parents('.js_dialog').fadeOut(200);//关闭
        });
        
    });
    
        
    //添加地址 检测是否 为空
    $('[name="sub"]').click(function(){//检查字符串
        var checkAddress = {//地址
            user_name : $('#name').val(),
            sex : $('#sex label input').eq(0).is(':checked')?'先生':'女士',
            user_phone : $('#phone').val(),
            user_address : $('#garden').text() +','+$('#floor').text() +','+ $('#room').val()
        };
        //检查不为空
        var s='';
        if(checkAddress.user_name==''){
             s += ',姓名'
        }
        if(checkAddress.user_phone==''){
             s += ',电话'
        }
        if($('#room').val()==''){
             s += ',房号'
        }
        if(checkAddress.user_name && checkAddress.user_phone && $('#room').val()){
            return ;//JSON.stringify(json);//json转字符串
        }
        $('#iosDialog2').find('span').text(s)
        $('#iosDialog2').fadeIn(200);
    });

//**************************************

    
    