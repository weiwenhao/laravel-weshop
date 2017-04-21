<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $permission;
    /**
     * @var RoleRepository
     */
    private $role;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $permission
     * @param RoleRepository $role
     */
    public function __construct(PermissionRepository $permission, RoleRepository $role)
    {
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perm_list = $this->permission->getPermList(['id', 'display_name', 'parent_id']);
        return view('admin.permission.list', compact('perm_list'));
    }

    /**
     * 得到嵌套的权限列表, 提供树形结构使用
     * @return mixed
     */
    public function getNestPermList()
    {
        $res = $this->permission->getNestPermList(['id', 'display_name', 'parent_id']);
        return $res;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perm_list = $this->permission->getPermList(['id', 'display_name', 'parent_id']);
        return view('admin.permission.create', compact('perm_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $perm = $this->permission->create($request->all());

        /*//将该权限分配给超级管理员  permission_role ,role特指'admin',即超级管理员,超级管理员不可删除
        $admin_role_name = config('admin.admin_role_name','admin');
        $role = $this->role->firstBy('name',$admin_role_name);
        if ($role){
            $role->perms()->attach($perm->id);
            //释放permission_role中间表的缓存,为什么要自己手动释放??
            \Cache::tags(\Config::get('entrust.permission_role_table'))->flush();
        }*/

        if(!$perm)
            return redirect('/admin/permissions/create')->withInput()->with('error', '系统错误，添加失败');
        \Cache::forget('perm_list');
        \Cache::forget('nest_perm_list');
        return redirect('/admin/permissions')->withSuccess('添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perm_child_ids = $this->permission->getChildPermIds($id);
        $perm_list = $this->permission->getPermList(['id', 'display_name', 'parent_id']);
        $perm = $this->permission->find($id);
        return view('admin.permission.edit',compact('perm','perm_list','perm_child_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $res = $this->permission->update($request->all(), $id);
        if (!$res)
            return redirect('/admin/permissions/'.$id.'/edit')->withInput()->withError('系统错误，修改失败');
        \Cache::forget('perm_list');//刷新缓存
        \Cache::forget('nest_perm_list');
        return redirect('/admin/permissions')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * 删除成功permssion后 应该同时删除 permssion_role表中的含有被删除的permssion_id的记录
         * 但是permssion_id 参考了 permssion表的id数据,并且添加了删除伴随,所以删除id的同时,会自动删除permssion中的记录
         */
        $perm_child_ids = $this->permission->getChildPermIds($id);
        $res = $this->permission->delete($perm_child_ids); //返回删除的记录数
        if(!$res){
            return redirect('/admin/permissions')->withError('系统错误,删除失败');
        }
        \Cache::forget('perm_list');
        \Cache::forget('nest_perm_list');
        return redirect('/admin/permissions')->withSuccess('删除成功');
    }
}
