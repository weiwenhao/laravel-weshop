@extends('admin.layouts.layout')
@section('css')
<style>

</style>
@stop
@section('content')
<section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">修改{{ $active->name }}活动</h3>

                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="/admin/actives/{{ $active->id }}"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input type="hidden" name="id" value="{{ $active->id }}">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">基本信息</a></li>
                            <li><a href="#tab_2" data-toggle="tab">活动详情</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">活动名称 *</label>

                                    <div class="col-md-4">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $active->name) }}" placeholder="请填写本次活动的名称, 最多10个字">
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label for="url" class="col-md-4 control-label">英文名称 *</label>

                                    <div class="col-md-4">
                                        <input id="url" type="text" class="form-control" name="url" value="{{ old('url', $active->url) }}" placeholder="对上述活动名称的合理的翻译即可,多个单词使用 _ 分隔">

                                        @if ($errors->has('url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sort') ? ' has-error' : '' }}">
                                    <label for="sort" class="col-md-4 control-label">权重(从小到大)</label>

                                    <div class="col-md-4">
                                        <input name="sort" type="number" class="form-control" value="{{ old('sort', $active->sort) }}" id="" placeholder="数字越大排名越靠前">
                                        @if ($errors->has('sort'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('sort') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('is_show') ? ' has-error' : '' }}">
                                    <label for="is_show" class="col-md-4 control-label">是否显示在主页</label>

                                    <div class="col-md-4">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_show" value="1" {{ old('is_show', $active->is_show) == 1?'checked':'' }}> 是
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_show"  value="0" {{ old('is_show', $active->is_show) == 0?'checked':'' }}> 否
                                        </label>
                                        @if ($errors->has('is_show'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('is_show') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('is_content') ? ' has-error' : '' }}">
                                    <label for="is_content" class="col-md-4 control-label">是否存在活动详情</label>

                                    <div class="col-md-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_content"  value="1"  {{ old('is_content', $active->is_content) == 1?'checked':'' }}> 是
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_content"  value="0"  {{ old('is_content', $active->is_content) == 0?'checked':'' }}> 否
                                        </label>
                                        @if ($errors->has('is_content'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('is_content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="label-control help-block">
                                            <span>若设计了活动详情,请将此项勾选为是!</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="sort" class="col-md-4 control-label">活动封面</label>

                                    <div class="col-md-4">
                                        <img src="{{ $active->image }}" alt="">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="image" class="col-md-4 control-label"></label>
                                    <div class="col-md-4">
                                        <div class="control-label"><input type="file" name="image" value="" class=""></div>
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @else
                                            <span class="help-block">
                                                <strong>若不更换封面,请勿选择任何图片</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <!-- 编辑器容器 -->
                                    <div class="col-md-12">
                                        <div id="content" name="content" type="text/plain"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ url('/admin/actives') }}" class="btn btn-block btn-default btn-flat">返回</a>
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
    var ue = UE.getEditor('content', {  //UE应该是UE的全局变量,类似于VUE,$等
        initialFrameWidth:"100%",
        initialFrameHeight:"500",
//        zIndex: 3000
    });
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        ue.setContent('{!! old('content', $active->content) !!}');
    });
</script>
@stop