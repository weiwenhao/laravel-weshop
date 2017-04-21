@extends('admin.layouts.layout')
@section('css')
<style>

</style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">权限列表</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url('/admin/permissions/create') }}" class="btn bg-olive" title="Collapse">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>权限名称</th>
                        <th style="width: 20%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($perm_list as $perm)
                        <tr>
                            <td>{{ $perm->id }}</td>
                            <td>{{ str_repeat('- - - - | ',$perm->level).$perm->display_name }}</td>
                            <td>
                                <a href="{{ url('/admin/permissions/'.$perm->id.'/edit') }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                <form action="{{ url('/admin/permissions/'.$perm->id) }}" method="post" style="display: inline">
                                    {{ csrf_field() }} {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-danger" onclick="javascript:return confirm('该权限的子权限将一并删除, 你确定要删除该权限吗?')">
                                        <i class="fa  fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer-->
        </div>
    </section>
    <!-- /.content -->
@stop
@section('js')
<script>

</script>
@stop