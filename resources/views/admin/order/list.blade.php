@extends('admin.layouts.layout')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css">
    <style>
        th, td { white-space: nowrap; }
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
                <h3 class="box-title">订单列表</h3>
            </div>
            <div class="box-body">
                <form class="form-inline" id="shaixuan">
                    <div class="form-group">
                        <label for="is_pay">是否支付：</label>
                        <select name="shaixuan" id="is_pay" class="form-control">
                            <option value="">全部</option>
                            <option value=1 selected>已支付</option>
                            <option value=0>未支付</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">订单状态：</label>
                        <select name="shaixuan" id="status" class="form-control">
                            <option value="">全部</option>
                            <option value=0 selected>未受理</option>
                            <option value=1>已受理</option>
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
            <hr>
            <div class="box-body">
                    批量操作：
                    <button class="btn btn-primary handel-order" value="1">受理</button>
                    <button class="btn btn-success handel-order" value="2">完成</button>
                    <button class="btn btn-danger handel-order" value="3">关闭</button>
                    <div id="buttons">
                    </div>
            </div>
            <div class="box-body">
                <table id="datatables" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th ><input type="checkbox" class="checkall"/></th>
                            <th>订单号</th>
                            <th>订单内容</th>
                            <th>个人信息</th>
                            <th>是否支付</th>
                            <th>订单状态</th>
                            <th>宿舍楼</th>
                            <th>创建时间</th>
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
    {{--datatables--}}
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables/extensions/Buttons/js/dataTables.buttons.js"></script>
    <script src="/plugins/datatables/extensions/Buttons/js/buttons.print.js"></script>
    <script>
        /**
         * datatables配置
         * @type {jQuery}
         */
        var table = $('#datatables').DataTable( {
            "dom": "<'row'<'col-sm-1'B> <'col-sm-5'l><'col-sm-6'f> >" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                extend: 'print',
                text: '打印',
                autoPrint: false,
                title : '外卖订单 {{ date('Y-m-d')}}',
                exportOptions: {
                    stripHtml : false,
//                    columns : [1,2,3,7,8] //打印哪些列
                }
            }],
            "lengthMenu": [ 10, 25, 50, 100, 999 ],
            "scrollX": false, //水平滚动条
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
            "order": [[ 7, "desc" ]],
            "serverSide": true,//开启服务器模式
            processing: true,
            "searchDelay": 1000, //搜索框请求间隔
            // "lengthMenu": [15,25,50], //自定义每页显示条数菜单

            "search" : {
                "regex": true  //正则搜索还是精确搜索
            },
            "ajax": {
                url : '/admin/orders/dt_data',
                /*data : function(){
                    return {
                        'is_pay' : $('#is_pay option:selected').val(),
                        'status' : $('#status option:selected').val(),
                    }
                },*/
                /*data : {
                        'is_pay' : function(){
                            return  $('#is_pay option:selected').val();
                        },
                        'status' : function(){
                            return  $('#status option:selected').val();
                        },
                },*/
                "data": function ( ext ) {
                    ext.is_pay = $('#is_pay option:selected').val();
                    ext.status = $('#status option:selected').val();
                    ext.floor_name = $('#floor_name option:selected').val();
                }
            },
            "columns": [
                {
                    "orderable" : false,
                    searchable: false,
                    "sClass": "text-center",
                    "data": "order_goods_id",
                    "render": function (data, type, full, meta) {
                        return '<input type="checkbox"  class="checkchild"  value="' + data + '" />';
                    },
                    "bSortable": false
                },
                {
                    'data':'order_id', //对应json中的字段
                },
                {
                    "orderable" : false,
                    searchable: false,
                    'data' : 'order_content',
                },
                {
                    "orderable" : false,
                    searchable: false,
                    'data':'self_info'
                },
                {
                    "orderable" : false,
                    searchable: false,
                    'data':'is_pay',
                    render : function (data, type, row, meta) {
                        // data : '0' or '1'
                        if(Number(data)){
                            return '<i class="fa fa-check text-success"></i>';
                        }
                        return '<i class="fa fa-close text-danger"></i>';
                    }
                },
                {
                    searchable: false,
                    'data':'status',
                    render : function (data, type, row, meta) {
                        data = Number(data)
                        // data : '0' or '1'
                        //1->已处理,2->已经完成,3->已关闭   js中 "" => 0
                        if(data == 0){
                            return '未受理';
                        }else if(data == 1){
                            return '已受理';
                        }else if(data == 2){
                            return '已完成';
                        }else if(data == 3){
                            return '已关闭';
                        }
                    }
                },
                {
                    'data':'floor_name'
                },
                {
                    'data': 'created_at'
                },
                /*{
                    'data' : 'action'
                }*/
            ],

        });
        table.buttons().container()
            .appendTo( $('#buttons', table.table().container() ) );
        /**
         *筛选按钮
         */
        $('[name=shaixuan]').change(function (event) {
            event.preventDefault();//组织默认提交事件
            table.ajax.reload(null, false); //databales对象从新加载
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
         *
         * 订单处理
         */
        $(".handel-order").click(function () {
            //长度判断
            if ($(".checkchild:checked").length < 1){
                swal("请勾选需要操作的订单!", '', "warning")
                return;
            };
            //得到按钮文字
            let btn_text = $(this).text();
            let btn_val = $(this).val();
            swal({
                    title: "确认"+btn_text+"?",
                    text: "你确定要将勾选订单设置为已"+btn_text+"吗",
                    /*type: "warning",*/
                    showCancelButton: true,
                    confirmButtonColor: "#3c8dbc",
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: true
                },
                ()=>{
                    var order_goods_ids = [];
                     $(".checkchild:checked").each(function () {
                         order_goods_ids.push(Number($(this).val()));
                     });
                    //点击确定后回调
                    $.ajax({
                    	type: "PUT",
                    	url: "/admin/orders",
                    	data:{
                    	    'order_goods_ids':order_goods_ids,
                            'status' :btn_val,
                        },
                    	success: function(msg){ //后台返回的数据在这里直接返回
                            table.ajax.reload(null, false); //databales对象从新加载
                            swal("修改成功", msg+'条订单已经'+btn_text, "success")
                    	},
                    	error: function (error) { //200以外的状态码走这里
                            swal("系统错误", '', "danger")
                    	}
                    });
                });
        });


        $.ajaxSetup({ //这段话的意思使用ajax,会将csrf加入请求头中
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /**
         * ajax删除
         */
       /*
        $('body').on('click', 'button.del', function() {
            var url = '/admin/orders/'+$(this).val(); //this代表删除按钮的DOM对象
            if( !confirm('你确定要删除该分类吗?')){
                return false;
            }
            $.ajax({
                type: "DELETE",
                url: url,
                success: function(data){
                    if (data){
                        //刷新dt
                        table.ajax.reload(null, false); //databales对象从新加载
                        alert('删除成功');
                    }
                }
            });
        });*/
    </script>
@stop