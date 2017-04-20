@extends('admin.layouts.layout')
@section('css')
    <style>

    </style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        @if (session('error'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> {{ session('error') }}</h4>
            </div>
        @endif
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">修改权限</h3>

                <div class="box-tools pull-right">

                </div>
            </div>
            <form action="{{ url('/admin/permission/'.$perm->id) }}" method="post" class="form-horizontal">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1" >
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{ $perm->id }}">
                        <div class="form-group {{ $errors->has('parent_id')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">父级权限</label>
                            <div class="col-md-6">
                                <select name="parent_id" id="select" class="form-control"
                                        @change="changeForm"
                                >
                                    <option value="0">请选择</option>
                                    @foreach($perm_list as $key => $value)
                                        @if(!in_array($value->id, $perm_child_ids))
                                            <option value="{{ $value->id }}"   level="{{ $value->level }}"  {{ $value->id == old('parent_id', $perm->parent_id)?'selected':'' }}>
                                                {{ str_repeat('- - - - | ',$value->level).$value->display_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                    @if($errors->has('parent_id'))
                                        <span class="help-block">{{ $errors->first('parent_id') }}</span>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div v-if="level[0]"> {{--顶级权限--}}
                            <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">*权限名称</label>
                                <div class="col-md-6">
                                    <input type="text" name="display_name" value="{{ old('display_name', $perm->display_name) }}" class="form-control" id="inputError" placeholder="对应左侧菜单名称">
                                    @if($errors->has('display_name'))
                                        <span class="help-block">{{ $errors->first('display_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限值</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" value="{{ old('name', $perm->name) }}" class="form-control" id="inputError" placeholder="例:  对上述权限名称的合理且唯一翻译即可,主要用于顶级菜单高亮">
                                    @if($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('icon')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限图标</label>
                                <div class="col-md-6">
                                    <input type="text" name="icon" value="{{ old('icon', $perm->icon) }}" class="form-control" id="inputError" placeholder="例: fa-home  请参照font-awesome图标表">
                                    @if($errors->has('icon'))
                                        <span class="help-block">{{ $errors->first('icon') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('sort')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权重</label>
                                <div class="col-md-6">
                                    <input type="text" name="sort" value="{{ old('sort', $perm->sort) }}" class="form-control" id="inputError" placeholder="数字越小,越靠前">
                                    @if($errors->has('sort'))
                                        <span class="help-block">{{ $errors->first('sort') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">描述</label>
                                <div class="col-md-6">
                                    <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description', $perm->desciption) }}</textarea>
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
                                    <input type="text" name="display_name" value="{{ old('display_name', $perm->display_name) }}" class="form-control" id="inputError" placeholder="对应左侧二级无图标菜单名称">
                                    @if($errors->has('display_name'))
                                        <span class="help-block">{{ $errors->first('display_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限值</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" value="{{ old('name', $perm->name) }}" class="form-control" id="inputError" placeholder="例:  role.list 用于菜单高亮, 并且还会和路由名称进行判断.">
                                    @if($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('url')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限链接</label>
                                <div class="col-md-6">
                                    <input type="text" name="url" value="{{ old('url', $perm->url) }}" class="form-control" id="inputError" placeholder="例:permission   和上述的list的前缀一致,且和resources路由名称一致, 用于二级连接跳转">
                                    @if($errors->has('url'))
                                        <span class="help-block">{{ $errors->first('url') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('sort')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权重</label>
                                <div class="col-md-6">
                                    <input type="text" name="sort" value="{{ old('sort', $perm->sort) }}" class="form-control" id="inputError" placeholder="数字越小越靠前">
                                    @if($errors->has('sort'))
                                        <span class="help-block">{{ $errors->first('sort') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">描述</label>
                                <div class="col-md-6">
                                    <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description', $perm->desciption) }}</textarea>
                                    @if($errors->has('description'))
                                        <span class="help-block">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div v-if="level[2]"> {{--三级权限,其基础是展示数据,因此其建立在list列表的基础上--}}
                            <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限名称</label>
                                <div class="col-md-6">
                                    <input type="text" name="display_name" value="{{ old('display_name', $perm->display_name) }}" class="form-control" id="inputError" placeholder="添加用户  删除用户 修改用户">
                                    @if($errors->has('display_name'))
                                        <span class="help-block">{{ $errors->first('display_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">权限值</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" value="{{ old('name', $perm->name) }}" class="form-control" id="inputError" placeholder="例: role.create   role.edit   role.destroy">
                                    @if($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                                <label class="col-md-3 control-label" for="inputError">描述</label>
                                <div class="col-md-6">
                                    <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description', $perm->description) }}</textarea>
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
                        <a href="{{ url('/admin/permission') }}" class="btn btn-block btn-default btn-flat">返回</a>
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
                level : [true,false,false]
            },
            created(){
                this.changeForm(); //实例渲染完毕
            },
            mounted(){
            },
            methods : {
                changeForm(){
                    var level = $('#select option:selected').attr('level')*1 + 1;
                     console.log(level);
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