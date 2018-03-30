@extends('admin.layouts.layout')
@section('css')
    <style>
    </style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">商品回收站</h3>

                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="datatables" class="table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>价格(元)</th>
                        <th>分类名称</th>
                        <th>上架</th>
                        <th>预览图</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@stop
@section('js')
    <script>
        /**
         * datatables配置
         * @type {jQuery}
         */
        var table = $('#datatables').DataTable( {
            stateSave: true,//保存当前页面状态,再次刷新进来依旧显示当前状态,比如本页的排序规则,显示记录条数
            language: dt_language, //语言国际化
            "order": [[ 6, "desc" ]],
            "serverSide": true,//开启服务器模式
            'processing': true,
            "searchDelay": 1000, //搜索框请求间隔
            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                "url" : '/admin/deled_goods/deled_goods_dt_data',
            },
            "columns": [
                {
                    width : '15%',
                    'data':'name',
                },
                {
                    'data':'price',
                },
                {
                    'data':'category.name',
                },
                {
                    'data':'is_sale',
                    searchable: false,
                    render : function (data, type, row, meta) {
                        // data : '0' or '1'
                        if(Number(data)){
                            return '<i class="fa fa-check text-success"></i>';
                        }
                        return '<i class="fa fa-close text-danger"></i>';
                    }
                },
                {
                    searchable: false, //是否参与搜索
                    'data':'sm_image',
                    "orderable" : false,
                    render : function (data, type, row, meta) {
                        return '<img src="'+data+'" alt="">';
                    }
                },
                {
                    'data':'created_at'
                },
                {
                    searchable: false,
                    'data' : null, //对应服务器端
                    "orderable" : false, //是否开启排序
                    'width' : '15%',
                    render: function(data, type, row, meta) {
                        return "<a href='/admin/goods/"+row.id+"/edit' class='btn btn-info edit'><i class='fa fa-edit'></i></a>  " +
                            "<button value="+row.id+" class='btn btn-success del'><i class='fa fa-refresh'></i></button>";
                    }
                }

            ],
        });

        /**
         * ajax还原
         */
        $('body').on('click', 'button.del', function() {
            var url = '/admin/deled_goods/refresh/'+$(this).val(); //this代表删除按钮的DOM对象

            swal({
                title: "你确定要还原该商品吗?",
                text: "",
                /*type: "warning",*/
                showCancelButton: true,
                confirmButtonColor: "#00BCD4",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: true
            }, function(){
                //点击确定后回调
                $.ajax({
                    type: "PUT",
                    url: url,
                    success: function(data){
                        //刷新dt
                        table.ajax.reload(null, false); //databales对象从新加载
                        swal("商品已还原", '', 'success')
                    },
                    error : function (errors) {
                        swal(errors.responseText, '', "error")
                    }
                });
            });
        });

        function downOrUpGoods(status) { //0代表下架商品  1代表上架商品
            let text = '上架';
            if(status === 0){
                text = '下架';
            }

            //长度判断
            if ($(".checkchild:checked").length < 1){
                swal("您还没有勾选商品呢!", '', "warning")
                return;
            };

            swal({
                title: text+"商品",
                text: "你确定要"+text+"勾选的商品吗?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: true
            },() => {
                //得到被选中的商品的id
                var goods_ids = [];
                $(".checkchild:checked").each(function () {
                    goods_ids.push(Number($(this).val()));
                });
                console.log(goods_ids);
            });

        }
    </script>
@stop