<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Eloquent\Repository;

class PermissionRepository extends Repository
{
    /**
     * Specify Model class name   该方法返回需要实例化的模型的完全限定名称
     * return  App/Models/User::class
     * @return mixed
     */
    public function modelName()
    {
        return Permission::class;
    }

    /**
     * 服务于后台权限列表
     * 1.取得排序好的权限列表(非嵌套,并附加了level字段,用来表示当前权限的级别)
     * 2.如果数据已经存在于缓存中,则从缓存中取出.否则调用排序数组,存入到缓存中,并返回权限列表
     * @param array $columns 取出的哪些列
     * @return mixed
     */
    public function getPermList($columns=['*'])
    {
        //在缓存中去除perm_list,如果不存在则讲return的结果存入到缓存中,并返回
        $res = \Cache::remember('perm_list',60,function () use ($columns) {
           return  $this->sortPermList($this->model->orderBy('sort', 'asc')->get(array_merge($columns, ['id','parent_id'])));
        });
        return $res;
    }

    /**
     * 得到当前的权限及其子权限的 id
     * @param $id   开始查找的权限的id
     * @return array [2,4,5]
     */
    public function getChildPermIds($id)
    {
        $perm_list = $this->sortPermList($this->model->orderBy('sort', 'asc')->get(), $id);
        $perm_ids = array_column($perm_list,'id');
        $perm_ids[] = (int)$id;
        return $perm_ids;
    }

    /**
     * 对权限列表数组进行排序(递归)
     * @param $perm_list   权限列表    [{},{},{}]
     * @param int $parent_id    排序起始点
     * @param int $level    当前权限的等级,顶级权限对应0
     * @return array    [{'id'=>1,...'parent_id'=>0...'level'=>0},{}...]
     */
    private function sortPermList($perm_list, $parent_id=0, $level=0)
    {
        $newArray = [];
        foreach ($perm_list as $key => $value){
            if($value->parent_id == $parent_id){
                $value->level = $level;
                $newArray[] = $value;
                $newArray = array_merge($newArray, $this->sortPermList($perm_list,$value->id,$level+1));
            }
        }
        return $newArray;
    }

    public function getNestPermList($columns=['*'])
    {
        $res = \Cache::remember('nest_perm_list',60,function () use ($columns) {
            return  $this->sortNestPermList($this->model->orderBy('sort', 'asc')->get($columns));
        });
        return $res;
    }

    private function sortNestPermList($perm_list, $parent_id=0)
    {
        $newArray = [];
        foreach ($perm_list as $key => $value){
            if ($value->parent_id == $parent_id){
                $value->children = $this->sortNestPermList($perm_list, $value->id);
                $newArray[] = $value;
            }
        }
        return $newArray;
    }
}