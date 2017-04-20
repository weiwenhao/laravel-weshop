@extends('admin.layouts.layout')
@section('css')
<style>

</style>
@stop
@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>
            <div class="error-content">
                <br>
                <h3><i class="fa fa-warning text-yellow"></i> 您没有权限访问该界面</h3>
                    <a class="btn btn-warning" href="{{ url()->previous() }}"><i class="fa fa-mail-reply"></i> 返回</a>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@stop
@section('js')
<script>
	
</script>
@stop