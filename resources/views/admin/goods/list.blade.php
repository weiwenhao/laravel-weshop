@extends('admin.layouts.layout')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
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
                <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品名称</th>
                        <th>价格(元)</th>
                        <th>分类名称</th>
                        <th>上架</th>
                        <th>精品</th>
                        <th>图片</th>
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
    {{--datatables--}}
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        /**
         * datatables配置
         * @type {jQuery}
         */
        var table = $('#datatables').DataTable( {
            stateSave: false,//保存当前页面状态,再次刷新进来依旧显示当前状态,比如本页的排序规则,显示记录条数
            language: {
                "sProcessing": "处理中...",
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sZeroRecords": "没有匹配结果",
                "info": "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上页",
                    "sNext": "下页",
                    "sLast": "末页"
                },

            }, //语言国际化
            "order": [[ 0, "desc" ]],
            "serverSide": true,//开启服务器模式
            'processing': true,
            "searchDelay": 1000, //搜索框请求间隔
            // "lengthMenu": [15,25,50], //自定义每页显示条数菜单

            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                "url" : '/admin/goods/dt_goods',
            },
            "columns": [
                {
                    'data':'id', //对应json中的字段,为取出
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
                    'data':'is_on_sale',
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
                        if(row.name == 'admin'){
                            return "<a href='/admin/goods/"+row.id+"/edit' class='btn btn-info edit'><i class='fa fa-edit'></i></a>";
                        }
                        return "<a href='/admin/goods/"+row.id+"/edit' class='btn btn-info edit'><i class='fa fa-edit'></i></a>  " +
                            "<button value="+row.id+" class='btn btn-danger del'><i class='fa fa-trash'></i></button>";
                    }
                }

            ],

        });
        /**
         * ajax删除
         */
        $.ajaxSetup({ //这段话的意思使用ajax,会将csrf加入请求头中
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', 'button.del', function() {
            var url = '/admin/goods/'+$(this).val(); //this代表删除按钮的DOM对象
            if( !confirm('你确定删除该商品吗?')){
                return false;
            }
            $.ajax({
                type: "DELETE",
                url: url,
                success: function(data){
                    if (data == 1){
                        //刷新dt
                        table.ajax.reload(null, false); //databales对象从新加载
                        alert('删除成功');
                    }
                },
                error : function (errors) {
                     alert(errors.responseText);
                }
            });
        });
    </script>
@stop