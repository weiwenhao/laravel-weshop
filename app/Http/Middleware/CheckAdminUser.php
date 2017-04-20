<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //原则: 最大权限原则 -> 没有限制的都可以访问
        /**
         * \Route::currentRouteName()
         * role.index       这两个对应权限中的 role.list
         * role.dt_index
         *
         * role.create      这两个对应权限中的 role.create
         * role.store
         *
         * role.edit        这两个对应权限中的 role.edit
         * role.update
         *
         * role.destroy     对应权限中的 role.destroy
         *
         *
         */
        $routeName = \Route::currentRouteName();
        $user = \Auth::guard('admin')->user();
        $prefix_route = substr($routeName,0,strrpos($routeName,'.')+1);
        if($user->hasRole(config('admin.admin_role_name','admin')))
            return $next($request);
        switch ($routeName)
        {
            case $prefix_route.'index':
            case $prefix_route.'dt_index':
                if (!$user->can($prefix_route.'list'))
                    abort('403','您的权限不足!');
                break;

            case $prefix_route.'create':
            case $prefix_route.'store':
                if (!$user->can($prefix_route.'create'))
                    abort('403','您的权限不足!');
                break;

            case $prefix_route.'edit':
            case $prefix_route.'update':
                if (!$user->can($prefix_route.'edit'))
                    abort('403','您的权限不足!');
                break;

            case $prefix_route.'destroy':
                if (!$user->can($prefix_route.'destroy'))
                    abort('403','您的权限不足!');
                break;
            default :
        }
        return $next($request);
    }
}
