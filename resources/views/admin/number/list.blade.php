@extends('admin.layouts.layout')
@section('css')
<style>

</style>
@stop
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i>数据格式错误,请仔细填写</h4>
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <form action="{{ route('numbers.index', ['goods_id'=>$goods->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <h3 class="box-title">库存列表 --- {{ $goods->name }}</h3>
                    <div class="box-tools pull-right">
                        {{--<a href="{{ url('/admin/goods') }}" class="btn bg-olive" title="Collapse">
                            <i class="fa fa-plus"></i>
                        </a>--}}
                    </div>
                </div>
                <div class="box-body">
                    <span>库存表中的价格默认为空, 使用商品的默认价格,如果需要特例处理,手动设置价格即可!</span>
                </div>
                <div class="box-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            @foreach($goods_attrs as $attr_name => $goods_attr)
                                <th>{{ $attr_name }}</th>
                            @endforeach
                            <th style="width: 15%">库存量</th>
                            <th style="width: 15%">价格(xx.xx)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($numbers as $number)
                            <tr>
                                @foreach($goods_attrs as $goods_attr)
                                    <td>
                                        <select name="" id="" class="form-control" disabled>
                                            @foreach($goods_attr as $value)
                                                <option value="{{ $value->goods_attr_id }}"
                                                    {{ in_array($value->goods_attr_id, explode(',', $number->goods_attribute_ids))?'selected':'' }}
                                                >
                                                    {{ $value->attribute_value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                                <td>
                                    <div class="form-group {{ $errors->has('number.'.$number->id) ? ' has-error' : '' }}">
                                        <input type="number" required  min="0" class="form-control" name="number[{{ $number->id }}]" value="{{ old('number.'.$number->id, $number->number) }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group {{ $errors->has('price.'.$number->id) ? ' has-error' : '' }}">
                                        <input type="text" class="form-control" name="price[{{ $number->id }}]" value="{{ old('price.'.$number->id, $number->price) }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer-->
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ url('/admin/goods') }}" class="btn btn-block btn-default btn-flat">返回</a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary btn-flat">更新</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@stop
@section('js')
<script>

</script>
@stop