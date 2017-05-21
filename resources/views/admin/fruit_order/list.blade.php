@extends('admin.layouts.layout')
@section('css')
    <style>
        #shaixuan .form-group {
            margin-right: 15px;
        }
    </style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">水果订单列表</h3>
            </div>
            <div class="box-body">
                <form class="form-inline" id="shaixuan">
                    <div class="form-group">
                        <label for="status">订单状态：</label>
                        <select name="shaixuan" id="status" class="form-control">
                            <option value="">全部</option>
                            <option value=0 selected>待处理</option>
                            <option value=1>待完成</option>
                            <option value=2>已完成</option>
                            <option value=3>已关闭</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="floor_name">宿舍楼：</label>
                        <select name="shaixuan" id="floor_name" class="form-control">
                            <option value="">全部</option>
                            <option value='梅香楼'>梅香楼</option>
                            <option value='兰洁楼'>兰洁楼</option>
                            <option value='菊清楼'>菊清楼</option>
                            <option value='竹贞楼'>竹贞楼</option>

                            <option value='诚敬楼'>诚敬楼</option>
                            <option value='恭谦楼'>恭谦楼</option>
                            <option value='谨信楼'>谨信楼</option>
                            <option value='勤勉楼'>勤勉楼</option>

                            <option value='孝悌楼'>孝悌楼</option>
                            <option value='三省楼'>三省楼</option>
                            <option value='友谅楼'>友谅楼</option>
                            <option value='互荣楼'>互荣楼</option>

                            <option value='明得楼'>明得楼</option>
                            <option value='明志楼'>明志楼</option>

                            <option value='日善楼'>日善楼</option>
                            <option value='兼善楼'>兼善楼</option>

                            <option value='思勉楼'>思勉楼</option>
                            <option value='思齐楼'>思齐楼</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>订单信息</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
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
            "dom":  "<'row'<'col-sm-12'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12'p>>",
            "lengthMenu": [ 10, 25, 50, 100, 999 ],
            "scrollX": false, //水平滚动条
            stateSave: false,//保存当前页面状态,再次刷新进来依旧显示当前状态,比如本页的排序规则,显示记录条数
            language: dt_language, //语言国际化
            "order": [[2, 'desc']],
            "serverSide": true,//开启服务器模式
            processing: true,
            "searchDelay": 1000, //搜索框请求间隔
            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                url : '/admin/fruit_orders/dt_data',
                "data": function ( ext ) {
                    ext.status = $('#status option:selected').val();
                    ext.floor_name = $('#floor_name option:selected').val();
                }
            },
            "columns": [
                {
                    "orderable" : false,
                    searchable: false,
                    'data' : 'order_info',
                    "render": function (data, type, full, meta) {
                        return full.name +' '+full.phone +
                            '<br>'+
                            full.floor_name+' '+full.number +
                            '<br>'+
                            data +
                            '<br>'+
                            full.paid_at;
                    },
                },

                {
                    "orderable" : false,
                    searchable: false,
                    'data' : 'action'
                },
                //下面为隐藏列,仅供搜索
                {
                    "name" : 'paid_at',
                    "data" : 'paid_at',
                    "visible": false
                },
                {
                    "name" : 'orders.order_id', //订单号
                    "data" : 'order_id',
                    "visible": false
                },
                {
                    "name" : 'order_goods.goods_name', //商品名称
                    "data" : 'goods_name',
                    "visible": false
                },
                {
                    "name" : 'orders.name', //用户真实姓名
                    "data" : 'name',
                    "visible": false
                },
                {
                    "name" : 'phone', //用户的电话号码
                    "data" : 'phone',
                    "visible": false
                },

            ],

        });
        /**
         *筛选按钮
         */
        $('[name=shaixuan]').change(function () {
            //变量重新赋值
            table.ajax.reload(null, false); //databales对象从新加载
        });
        /**
         *
         * 订单处理
         */

        $('body').on('click', 'button.handel-order', function() { //该方法是全局的,即使按钮是被后渲染处理的依旧有效
            //得到按钮文字
            let btn_text = $(this).text();
            let status = $(this).attr('status');
            let order_goods_id = $(this).attr('order_goods_id');
            swal({
                    title: "确认"+btn_text+"?",
                    text: "你确定要将该订单订单设置为已"+btn_text+"吗",
                    /*type: "warning",*/
                    showCancelButton: true,
                    confirmButtonColor: "#3c8dbc",
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: true
                },
                ()=>{
                    //点击确定后回调
                    $.ajax({
                    	type: "PUT",
                    	url: "/admin/orders",
                    	data:{
                    	    'order_goods_ids':[order_goods_id],
                            'status' :status,
                        },
                    	success: function(msg){ //后台返回的数据在这里直接返回
                            table.ajax.reload(null, false); //databales对象从新加载
                            swal("修改成功", '订单已'+btn_text, "success");
                            swal({
                                title: "修改成功",
                                text: '订单已'+btn_text,
                                type: "success",
                                showConfirmButton : false,
                                timer: 1000
                            });
                    	},
                    	error: function (error) { //200以外的状态码走这里
                            swal("系统错误", '', "danger")
                    	}
                    });
                });
        });
    </script>
@stop