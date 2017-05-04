<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\Role;
use App\Repositories\Eloquent\Repository;
use Yajra\Datatables\Datatables;

class AdminRepository extends Repository
{
    /**
     * Specify Model class name   该方法返回需要实例化的模型的完全限定名称
     * return  App/Models/User::class
     * @return mixed
     */
    public function modelName()
    {
        return Admin::class;
    }

    public function getDtAdmins()
    {
        $admins = $this->model->with('roles');
        return Datatables::of($admins)->addColumn('roles', function (Admin $admin){
            //通过admin,处理出一段希望展示出来的roles字段,以行为单位
            return $admin->roles->map(function ($role){
                return $role->display_name;
            })->implode('<br>');
        })->rawColumns(['roles'])->make(true);
        //rawColumns不做处理的字段,即不被转义处理的字段.
        //因为laravel属于在 blade模板输出时通过{{}}转义的字段,但dt的输出流程中不存在{{}}的过程,因此要进行输出转义
    }

}