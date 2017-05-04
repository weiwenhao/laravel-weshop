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
                <h3 class="box-title">添加属性 -- {{ $type->name }}</h3>

                <div class="box-tools pull-right">
                    {{--todo--}}
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('attributes.store', ['type_id'=>$type->id]) }}">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1">
                        {{ csrf_field() }}
                        <input type="hidden" name="type_id" value="{{ $type->id }}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">属性名称</label>
                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="尺码">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">属性类型</label>

                            <div class="col-md-4">
                                <label class="radio-inline">
                                    <input type="radio" name="type"  value="唯一"  {{ old('type', '唯一') == '唯一'?'checked':'' }}> 唯一
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type"  value="可选"  {{ old('type', '唯一') == '可选'?'checked':'' }}> 可选
                                </label>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <span>可选属性在购买时可供用户选择,如尺码 应该为可选属性, 品牌一件商品只有一个,应该为唯一属性</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                            <label for="option_values" class="col-md-4 control-label">属性可选值</label>

                            <div class="col-md-4">
                                <input id="text" type="text" class="form-control" name="option_values" value="{{ old('option_values') }}" placeholder="S,M,L,XL,XXL 请尽量全面">

                                @if ($errors->has('option_values'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('option_values') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <span>多个值请用 逗号 隔开,该值为空时,属性值由商品录入员手动录入</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ route('attributes.index', ['type_id'=>$type->id]) }}" class="btn btn-block btn-default btn-flat">返回</a>
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