@extends('admin.layouts.layout')
@section('css')
    {{--日期选择控件--}}
    <script src="/plugins/laydate-v1.1/laydate/laydate.js"></script>
<style>

</style>
@stop
@section('content')
<section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">添加商品</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="/admin/goods"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">基本信息</a></li>
                            <li><a href="#tab_2" data-toggle="tab">商品描述</a></li>
                            <li><a href="#tab_3" data-toggle="tab">商品属性</a></li>
                        </ul>
                        <div class="tab-content">

                                <div class="tab-pane active" id="tab_1">
                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label for="category_id" class="col-md-3 control-label">商品分类 *</label>
                                        <div class="col-md-6">
                                            <select name="category_id" class="form-control select2" data-placeholder="请选择" style="width: 100%;">
                                                <option value="">请选择</option>
                                                <option value="1">校园外卖</option>
                                                <option value="2">水果超市</option>
                                                <option value="3">二手市场</option>
                                            </select>
                                            @if ($errors->has('role_ids'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('role_ids') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-3 control-label">商品名称 *</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="30字限制,可在此填写一些商品的必要信息" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label for="price" class="col-md-3 control-label">商品价格 *</label>

                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input name="price" type="number" class="form-control" id="price" value="{{ old('price') }}" placeholder="精确到0.01">
                                                <div class="input-group-addon">元</div>
                                            </div>
                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('promote_price') ? ' has-error' : '' }}">
                                        <label for="promote_price" class="col-md-3 control-label">促销价格</label>

                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input name="promote_price" type="number" class="form-control" id="" value="{{ old('promote_price') }}" placeholder="精确到0.01">
                                                <div class="input-group-addon">元</div>
                                            </div>
                                            @if ($errors->has('promote_price'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('promote_price') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('promote_start_at') || $errors->has('promote_stop_at') ? ' has-error' : '' }}">
                                        <label for="promote_start_at" class="col-md-3 control-label">促销时间</label>
                                        <div class="col-md-3">
                                            <input name="promote_start_at" class="form-control" id="promote_start_at" value="{{ old('promote_start_at') }}" placeholder="促销开始时间">
                                            @if ($errors->has('promote_start_at'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('promote_start_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input name="promote_stop_at" class="form-control" id="promote_stop_at" value="{{ old('promote_stop_at') }}"  placeholder="促销结束时间">
                                            @if ($errors->has('promote_stop_at'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('promote_stop_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('sort') ? ' has-error' : '' }}">
                                        <label for="sort" class="col-md-3 control-label">权重</label>

                                        <div class="col-md-6">
                                            <input name="sort" type="number" class="form-control" value="{{ old('price',100) }}" id="" placeholder="数字越大,商品展示越靠前">
                                            @if ($errors->has('sort'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('sort') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('is_on_sale') ? ' has-error' : '' }}">
                                        <label for="is_on_sale" class="col-md-3 control-label">是否上架</label>

                                        <div class="col-md-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_on_sale" value="1" {{ old('is_on_sale', 1) == 1?'checked':'' }}> 是
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_on_sale"  value="0" {{ old('is_on_sale', 1) == 0?'checked':'' }}> 否
                                            </label>
                                            @if ($errors->has('is_on_sale'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('is_on_sale') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('is_best') ? ' has-error' : '' }}">
                                        <label for="is_best" class="col-md-3 control-label">是否精品</label>

                                        <div class="col-md-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_best"  value="1"  {{ old('is_best', 0) == 1?'checked':'' }}> 是
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_best"  value="0"  {{ old('is_best', 0) == 0?'checked':'' }}> 否
                                            </label>
                                            @if ($errors->has('is_best'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('is_best') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label for="image" class="col-md-3 control-label">商品图片 *</label>

                                        <div class="col-md-6">
                                            <input type="file" name="image">
                                            @if ($errors->has('is_best'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('is_best') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <!-- 编辑器容器 -->
                                    <div id="description" name="description" type="text/plain"></div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    It has survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ url('/admin/goods') }}" class="btn btn-block btn-default btn-flat">返回</a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary btn-flat">提交</button>
                    </div>
                </form>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
@stop
{{--引入ue编辑器--}}
@include('vendor.ueditor.assets')
@section('js')
<script>
    //ue浏览器
    var ue = UE.getEditor('description' /*{  //UE应该是UE的全局变量,类似于VUE,$等
        toolbars: [
            [
                'bold',
                'italic',
                'blockquote',//引用
                /!*'insertcode', //代码语言*!/
                'insertunorderedlist', //无序
                'insertorderedlist', //有序
                'insertvideo', //视频
                'insertimage',
            ]
        ],
        elementPathEnabled: false,
        enableContextMenu: false,
        autoClearEmptyNode:true,
        wordCount:false,
        imagePopup:false,
        autotypeset:{ indent: true,imageBlockLine: 'center' },
        initialFrameHeight: 140,
//        zIndex: 3000
    }*/);
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
    //select2
    $(".select2").select2({

    });
    laydate.skin('molv');
    let start = {
        elem: '#promote_start_at',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: laydate.now(), //设定最小日期为当前日期
        istime: true,
        choose: function(datas){
            end.start = datas //将结束日的初始值设定为开始日
        }
    }

    let end = {
        elem: '#promote_stop_at',
        format: 'YYYY-MM-DD hh:mm:ss',
        istime: true,
    }
    laydate(start);
    laydate(end);
</script>
@stop