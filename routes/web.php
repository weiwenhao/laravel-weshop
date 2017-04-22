<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function (){

});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
    //登录
    Route::get('login','Auth\LoginController@showLoginForm');
    Route::post('login','Auth\LoginController@login');
    //注册入口
    Route::get('register','Auth\RegisterController@showRegistrationForm');
    Route::post('register','Auth\RegisterController@register');

    Route::post('logout','Auth\LoginController@logout');
});
Route::group(['prefix' => 'admin', 'namespace'=>'Admin', 'middleware'=>['auth.admin','check.admin'] ], function () {
    Route::get('/',function (){
//            dd(Auth::guard('admin')->user()->name);
//        dd(auth('admin')->user());
//        dd(auth('admin')->user()->hasRole('admin'));
        return view('admin.index');
    });

    //商品管理区域
    //商品管理
    Route::get('/goods/dt_goods','GoodsController@dtGoods')->name('goods.index'); //定义路由名称和resource的index一致,方便对权限进行判断
    Route::resource('goods', 'GoodsController');
    //分类管理
    Route::get('/categories/dt_categories','CategoryController@dtCategories')->name('categories.index'); //定义路由名称和resource的index一致,方便对权限进行判断
    Route::resource('categories', 'CategoryController');

    //系统设置区域
    //权限管理
//    Route::get('/permission/get_nest_perm_list','PermissionController@getNestPermList')->name('menu.index');
    Route::resource('permissions','PermissionController');
    //角色管理
    Route::get('/roles/dt_roles','RoleController@dtRoles')->name('role.index');
    Route::resource('roles','RoleController');
    //管理员管理
    Route::get('/admins/dt_admins','AdminController@dtAdmins')->name('admin.index');
    Route::resource('admins','AdminController');
});