<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Repositories\AdminRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $admin;
    protected $role;

    /**
     * AdminController constructor.
     * @param $admin
     * @param $role
     */
    public function __construct(AdminRepository $admin, RoleRepository $role)
    {
        $this->admin = $admin;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admin.list');
    }
    /**
     * datatables数据源
     * @return mixed
     */
    public function dtData()
    {
        return $this->admin->getDtAdmins();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all(['id','display_name']);
        return view('admin.admin.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param AdminRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $res = $this->admin->create($request->all());
        if(!$res)
            return redirect('/admin/admins/create')->withError('系统错误,添加失败')->withInput();
        $res->roles()->attach($request->get('role_ids'));
        return redirect('/admin/admins')->withSuccess('添加成功');
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
        $admin = $this->admin->find($id);
        $role_ids = $admin->roles->pluck('id')->toArray();
        $roles = $this->role->all(['id','display_name']);
        return view('/admin/admin/edit', compact('admin', 'role_ids', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = $this->admin->find($id);
        $admin->name = $request->get('name');
        $admin->email = $request->get('email');
        if($request->get('password'))
            $admin->password = $request->get('password');

        $res = $admin->save();

        if(!$res)
            return redirect('/admin/admins/'.$id.'/edit')->withError('系统错误,修改失败')->withInput();
        //进行中间表的修改
        $admin->roles()->sync($request->get('role_ids',[]));
        return redirect('/admin/admins')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->admin->delete($id);
        return $res;
    }
}
