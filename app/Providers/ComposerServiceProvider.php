<?php

namespace App\Providers;

use App\Http\ViewComposers\AdminComposer;
use App\Http\ViewComposers\JssdkComposer;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //绑定菜单数据到后台
        \View::composer('admin.*', AdminComposer::class);

        //绑定jssdk
        \View::composer(['post.*', 'goods.goods'], JssdkComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
