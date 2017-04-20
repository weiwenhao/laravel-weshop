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
                <h3 class="box-title">修改角色</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            {{--<el-tree
                    :data="perms"
                    show-checkbox
                    node-key="id"
                    ref="tree"
                    :props="defaultProps">
            </el-tree>
            <el-button @click="getCheckedKeys">通过 key 获取</el-button>--}}
            <form action="{{ url('/admin/role/'.$role->id) }}" method="post" class="form-horizontal">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">*角色值</label>
                            <div class="col-md-6">
                                <input type="text" name="name" value="{{ old('name',$role->name) }}" class="form-control" id="inputError" placeholder="例:  admin">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">*角色名称</label>
                            <div class="col-md-6">
                                <input type="text" name="display_name" value="{{ old('display_name',$role->display_name) }}" class="form-control" id="inputError" placeholder="例:  超级管理员">
                                @if($errors->has('display_name'))
                                    <span class="help-block">{{ $errors->first('display_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">描述</label>
                            <div class="col-md-6">
                                <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description',$role->description) }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('perm_ids')?'has-error':'' }}">
                            <label class="col-md-3 control-label" for="inputError">拥有权限</label>
                            <div class="col-md-6">
                                @foreach($perms as $value)
                                    {{ str_repeat('- - - - - - | ',$value->level)}}
                                    <input type="checkbox"
                                           level="{{ $value->level }}"
                                           name="perm_ids[]"
                                           value="{{ $value->id }}"
                                            {{ in_array($value->id, old('perm_ids',$perm_ids))?'checked':'' }}
                                    >
                                    {{ $value->display_name }}
                                    <br>
                                @endforeach
                                @if($errors->has('perm_ids'))
                                    <span class="help-block">{{ $errors->first('perm_ids') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-4">
                        <a href="{{ url('/admin/role') }}" class="btn btn-block btn-default btn-flat">返回</a>
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
        $('input:checkbox').click(function () {
            //得到当前的复选框的选中状态
            var bool = $(this).prop('checked');
            //得到当前复选框的level值
            var level = $(this).attr('level');
            //选中 当前选中元素的所有子元素(同一类型中的元素)
            $(this).nextAll(':checkbox').each(function (k,v) {
                //k是索引,从0开始  v是所有满足nextAll条件的dom对象
                //当前level需要大于选中的level才被选中
                if( $(v).attr('level') > level ){
                    $(v).prop('checked',bool);
                }else{
                    //跳出each循环
                    return false;
                }

            })
            //选中 当前选中元素的所有父元素(同一类型中的元素)
            $(this).prevAll(':checkbox').each(function (k,v) {
                //k是索引,从0开始  v是所有满足prevAll条件的dom对象
                //当前level需要大于选中的level才被选中
                if( $(v).attr('level') < level ){
                    //level数字越小等级越高
                    $(v).prop('checked',true); //将找到的复选框勾选
                    level--; //将需找的等级提高一级
                }

            })
        });
        /*var app = new Vue({
         el: '#app',
         data : {
         perms:[],
         defaultProps: {
         children: 'children',
         label: 'display_name'
         }
         },
         created(){
         this.getNestPerms();
         },
         methods : {
         getNestPerms(){
         axios.get('/admin/permission/get_nest_perms', {

         })
         .then(response=> {
         this.perms = response.data;

         })
         .catch(error=> {
         console.log(error);
         });
         },
         getCheckedKeys() {
         console.log(this.$refs.tree.getCheckedKeys());
         },
         }
         });*/
    </script>
@stop