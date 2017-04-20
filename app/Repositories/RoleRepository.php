<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Eloquent\Repository;

class RoleRepository extends Repository
{
    /**
     * Specify Model class name   该方法返回需要实例化的模型的完全限定名称
     * return  App/Models/User::class
     * @return mixed
     */
    public function modelName()
    {
        return Role::class;
    }

}