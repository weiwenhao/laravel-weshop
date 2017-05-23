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
                <h3 class="box-title">修改分类</h3>

                <div class="box-tools pull-right">
                    {{--todo--}}
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="/admin/categories/{{ $category->id }}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1">
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">分类名</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sort') ? ' has-error' : '' }}">
                            <label for="sort" class="col-md-4 control-label">权重(升序)</label>

                            <div class="col-md-4">
                                <input name="sort" type="number" class="form-control" value="{{ old('sort', $category->sort) }}" id="" placeholder="">
                                @if ($errors->has('sort'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sort') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('is_show') ? ' has-error' : '' }}">
                            <label for="is_show" class="col-md-4 control-label">前台是否显示</label>

                            <div class="col-md-4">
                                <label class="radio-inline">
                                    <input type="radio" name="is_show" value="1" {{ old('is_show', $category->is_show) == 1?'checked':'' }}> 是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_show"  value="0" {{ old('is_show', $category->is_show) == 0?'checked':'' }}> 否
                                </label>
                                @if ($errors->has('is_show'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_show') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="sort" class="col-md-4 control-label">活动封面</label>

                            <div class="col-md-4">
                                <img src="{{ $category->logo }}" alt="">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="logo" class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <div class="control-label"><input type="file" name="logo" value="" class=""></div>
                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @else
                                    <span class="help-block">
                                        <strong>若不更换封面,请勿选择任何图片</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ url('/admin/categories') }}" class="btn btn-block btn-default btn-flat">返回</a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary btn-flat">提交</button>
                    </div>
                </div>
                <!-- /.box-footer-->
            </form>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@stop
@section('js')
    <script>
        $(".select2").select2();
    </script>
@stop