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
            <form class="form-horizontal" role="form" method="POST" action="/admin/categories/{{ $category->id }}">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1">
                        <input type="hidden" id="{{ $category->id }}">
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