<?php

namespace App\Http\ViewComposers;

use App\Repositories\PermissionRepository;
use Illuminate\View\View;

class AdminComposer
{
    private $permission;

    /**
     * AdminComposer constructor.
     * @param $permission
     */
    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    public function compose(View $view)
    {
        //菜单数据.用于左侧菜单栏
        $menus = $this->permission->getNestPermList();
        $view->with(compact('menus')); // compact('menus) == ['menus'=>$menus]
    }
}