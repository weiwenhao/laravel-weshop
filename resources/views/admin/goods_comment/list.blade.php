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
                <h3 class="box-title">商品"{{ $goods->name }}"的评论</h3>

                <div class="box-tools pull-right">
                    <div class="box-tools pull-right">
                        <a href="{{ url('/admin/goods') }}" class="btn btn-default" title="Collapse">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>内容</th>
                            <th>购买商品属性值</th>
                            <th>评价星级</th>
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
        let table = $('#datatables').DataTable( {
            stateSave: false,//保存当前页面状态,再次刷新进来依旧显示当前状态,比如本页的排序规则,显示记录条数
            language: dt_language, //语言国际化
            "order": [[ 0, "desc" ]],
            "serverSide": true,//开启服务器模式
            processing: true,
            "searchDelay": 1000, //搜索框请求间隔
            // "lengthMenu": [15,25,50], //自定义每页显示条数菜单

            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                "url" : '/admin/goods/{{ $goods->id }}/goods_comments/dt_data',
            },
            "columns": [
                {
                    "orderable" : false,
                    'data':'content',
                },
                {
                    "orderable" : false,
                    'data':'goods_attributes',
                },
                {
                    'data':'level',
                },
                {
                    'data': 'created_at',
                },
                {
                    searchable: false,
                    'data' : null, //对应服务器端
                    "orderable" : false, //是否开启排序
                    'width' : '20%',
                    render: function(data, type, row, meta) {
                        return "<button value="+row.id+" class='btn btn-danger del'><i class='fa fa-trash'></i></button>";
                    }
                }

            ],

        });

        //删除操作
        $('body').on('click', 'button.del', function() {
            var url = '/admin/goods/{{ $goods->id }}/goods_comments/'+$(this).val(); //this代表删除按钮的DOM对象
            swal({
                title: "你确定要删除用户对商品的评论吗?",
                text: "该操作将影响本店的信誉值,请谨慎操作",
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
                    success: function(msg){ //后台返回的数据在这里直接返回
                        table.ajax.reload(null, false); //databales对象从新加载
                        swal("删除成功", '', 'success')
                    },
                    error: function (error) { //200以外的状态码走这里
                        swal("系统错误", '', "error")
                    }
                });
            });
        });
    </script>
@stop