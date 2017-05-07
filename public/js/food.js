// 点击图片查看大图
    $(function(){
        var $androidActionSheet = $('#androidActionsheet');
        var $androidMask = $androidActionSheet.find('.weui-mask');
        var outImg = $('#outImg');
        $("#showAndroidActionSheet").on('click', function(){
            $androidActionSheet.fadeIn(200);
            $androidMask.on('click',function () {
                $androidActionSheet.fadeOut(200);
            });
            outImg.on('click',function () {
                $androidActionSheet.fadeOut(200);
            });
        });
    });