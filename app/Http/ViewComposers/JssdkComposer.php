<?php

namespace App\Http\ViewComposers;

use EasyWeChat\Foundation\Application;
use Illuminate\View\View;

class JssdkComposer
{
    private $wechat;

    /**
     * AdminComposer constructor.
     * @param Application $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    public function compose(View $view)
    {
        //菜单数据.用于左侧菜单栏
        $js = $this->wechat->js;
        $view->with(compact('js')); // compact('menus) == ['menus'=>$menus]
    }
}