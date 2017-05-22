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
                <h3 class="box-title">商品列表</h3>

                <div class="box-tools pull-right">
                    <div class="box-tools pull-right">
                        <a href="{{ url('/admin/goods/create') }}" class="btn bg-olive" title="Collapse">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                批量操作：
                <button class="btn btn-danger goods-down">下架</button>
                <button class="btn btn-success  goods-up">上架</button>
                {{--<button class="btn btn-danger handel-order" value="3">关闭</button>--}}
                <div id="buttons">
                </div>
            </div>
            <div class="box-body">
                <table id="datatables" class="table table-bordered table-striped ">
                    <thead>
                        <tr>
                            <td class="text-center"><input type="checkbox" class="checkall"/></td>
                            <th>商品名称</th>
                            <th>价格(元)</th>
                            <th>分类名称</th>
                            <th>上架</th>
                            <th>精品</th>
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
//            "scrollX": false, //水平滚动条
            stateSave: true,//保存当前页面状态,再次刷新进来依旧显示当前状态,比如本页的排序规则,显示记录条数
            language: dt_language, //语言国际化
            "order": [[ 6, "desc" ]],
            "serverSide": true,//开启服务器模式
            'processing': true,
            "searchDelay": 1000, //搜索框请求间隔
            // "lengthMenu": [15,25,50], //自定义每页显示条数菜单

            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                "url" : '/admin/goods/dt_data',
            },
            "columns": [
                {
                    "orderable" : false,
                    searchable: false,
                    "sClass": "text-center",
                    "data": "id",
                    "render": function (data, type, full, meta) {
                        return '<input type="checkbox"  class="checkchild"  value="' + data + '" />';
                    },
                    "bSortable": false
                },
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
                    'data':'is_best',
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
                        return "<a href='/admin/goods/"+row.id+"/numbers' class='btn btn-primary'><i class='fa fa-hourglass-end'></i></a>  " +
                            "<a href='/admin/goods/"+row.id+"/edit' class='btn btn-info edit'><i class='fa fa-edit'></i></a>  " +
                            "<button value="+row.id+" class='btn btn-danger del'><i class='fa fa-trash'></i></button>";
                    }
                }

            ],

        });


        /*
        * 下架商品
        * */
        $('.goods-up').click(function () { //0代表下架商品  1代表上架商品

            //长度判断
            if ($(".checkchild:checked").length < 1){
                swal("您还没有勾选商品呢!", '')
                return;
            };

            swal({
                title: "上架商品",
                text: "你确定要上架勾选的商品吗?",
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
                 axios.put('/admin/goods/is_sale', {
                  	'is_sale' : 1,
                     'goods_ids' : goods_ids
                 })
                 .then((response)=> {
                     table.ajax.reload(null, false); //databales对象从新加载
                     swal("上架成功", '您一共上架了'+response.data+'件商品', "success")
                 })
                 .catch(error=> {
                 	console.log(error.response.data)
                 });

            });

        });

        /*
        *
        * 批量上架商品
        * */
        $('.goods-down').click(function () {

            //长度判断
            if ($(".checkchild:checked").length < 1){
                swal("您还没有勾选商品呢!", '')
                return;
            };

            swal({
                title: "下架商品",
                text: "你确定要下架勾选的商品吗?",
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
                axios.put('/admin/goods/is_sale', {
                    'is_sale' : 0,
                    'goods_ids' : goods_ids
                })
                    .then((response)=> {
                        table.ajax.reload(null, false); //databales对象从新加载
                        swal("下架成功", '您一共下架了'+response.data+'件商品', "success")
                    })
                    .catch(error=> {
                        console.log(error.response.data)
                    });

            });

        });
        /**
         *
         * 批量操作
         */
        $(".checkall").click(function () {
            let check = $(this).prop("checked"); //prop是 checkbox的attribute属性
            $(".checkchild").prop("checked", check);
        });

        /**
         * ajax删除
         */
        $('body').on('click', 'button.del', function() {
            var url = '/admin/goods/'+$(this).val(); //this代表删除按钮的DOM对象

            swal({
                title: "你确定要删除该商品吗?",
                text: "商品被删除后会进入到回收站，且对用户不可见。",
                /*type: "warning",*/
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: true
            }, function(){
                //点击确定后回调
                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(data){
                        //刷新dt
                        table.ajax.reload(null, false); //databales对象从新加载
                        swal("删除成功", '', 'success')
                    },
                    error : function (errors) {
                        swal(errors.responseText, '', "danger")
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