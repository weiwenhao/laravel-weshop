@extends('admin.layouts.layout')
@section('css')
<style>

</style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        @if(session('error'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> {{ session('error') }}</h4>
            </div>
        @endif
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">添加权限</h3>

                <div class="box-tools pull-right">

                </div>
            </div>
            <form action="{{ url('/admin/permissions') }}" method="post" class="form-horizontal">
            <div class="box-body">
                <div class="col-md-10 col-md-offset-1" >
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('parent_id')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">父级权限</label>
                            <div class="col-md-6">
                                <select name="parent_id" id="select" class="form-control"
                                        @change="changeForm"
                                >
                                    <option value="0" level="-1">请选择</option>
                                    @foreach($perm_list as $key => $value)
                                        <option value="{{ $value->id }}"  level="{{ $value->level }}" {{ $value->id == old('parent_id')?'selected':'' }}>
                                            {{ str_repeat('- - - - | ',$value->level).$value->display_name }}
                                        </option>
                                    @endforeach
                                    @if($errors->has('parent_id'))
                                        <span class="help-block">{{ $errors->first('parent_id') }}</span>
                                    @endif
                                </select>
                            </div>
                        </div>
                    <div v-if="level[0]"> {{--顶级权限--}}
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限名称</label>
                            <div class="col-md-6">
                                <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control" id="inputError" placeholder="对应左侧顶级菜单名称">
                                @if($errors->has('display_name'))
                                    <span class="help-block">{{ $errors->first('display_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限值</label>
                            <div class="col-md-6">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="inputError" placeholder="对上述权限名称的合理且唯一翻译即可">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('icon')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限图标</label>
                            <div class="col-md-6">
                                <input type="text" name="icon" value="{{ old('icon') }}" class="form-control" id="inputError" placeholder="例: fa-home  请参照font-awesome图标表">
                                @if($errors->has('icon'))
                                    <span class="help-block">{{ $errors->first('icon') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('sort')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权重(从小到大)</label>
                            <div class="col-md-6">
                                <input type="text" name="sort" value="{{ old('sort',100) }}" class="form-control" id="inputError" placeholder="数值越小越靠前">
                                @if($errors->has('sort'))
                                    <span class="help-block">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">描述</label>
                            <div class="col-md-6">
                                <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div v-if="level[1]"> {{--二级权限--}}
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限名称</label>
                            <div class="col-md-6">
                                <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control" id="inputError" placeholder="对应左侧二级无图标菜单名称">
                                @if($errors->has('display_name'))
                                    <span class="help-block">{{ $errors->first('display_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限值</label>
                            <div class="col-md-6">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="inputError" placeholder="前缀请使用复数形式 例:  roles.list ">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('url')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限链接</label>
                            <div class="col-md-6">
                                <input type="text" name="url" value="{{ old('url') }}" class="form-control" id="inputError" placeholder="例: 和上述的list的前缀一致,且和resources路由名称一致">
                                @if($errors->has('url'))
                                    <span class="help-block">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('sort')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权重(从小到大)</label>
                            <div class="col-md-6">
                                <input type="text" name="sort" value="{{ old('sort',100) }}" class="form-control" id="inputError" placeholder="数值越小越靠前">
                                @if($errors->has('sort'))
                                    <span class="help-block">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">描述</label>
                            <div class="col-md-6">
                                <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div v-if="level[2] || level[3]"> {{--三级权限--}}
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限名称</label>
                            <div class="col-md-6">
                                <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control" id="inputError" placeholder="添加用户  删除用户 修改用户">
                                @if($errors->has('display_name'))
                                    <span class="help-block">{{ $errors->first('display_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">权限值</label>
                            <div class="col-md-6">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="inputError" placeholder="例:前缀请使用复数形式 例: roles.create   roles.edit   roles.destroy">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">描述</label>
                            <div class="col-md-6">
                                <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-2 col-md-offset-4">
                    <a href="{{ url('/admin/permissions') }}" class="btn btn-block btn-default btn-flat">返回</a>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-block btn-primary btn-flat">提交</button>
                </div>
            </div>
            <!-- /.box-footer-->
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@stop
@section('js')
<script>
    var app = new Vue({
        el: '#app',
        data : {
            level : [true,false,false, false]
        },
        created(){

        },

        methods : {
            changeForm(){
                 var level = $('#select option:selected').attr('level')*1 + 1;
                 this.level[0] = false;
                 for (let i=0;i < this.level.length; i++){
                     this.level.splice(i, 1, false);
                 }
                this.level.splice(level, 1, true)
            }
        }
    });
</script>
@stop