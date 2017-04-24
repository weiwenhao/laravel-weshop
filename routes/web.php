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

    /******************************商品管理区************************************/
    //商品管理
    Route::get('/goods/dt_data','GoodsController@dtData')->name('goods.index'); //定义路由名称和resource的index一致,方便对权限进行判断
    Route::resource('goods', 'GoodsController');
    Route::get('/types/ajax_types','TypeController@ajaxTypes')->name('goods.create');
    Route::get('/types/{type_id}/attributes/ajax_attributes','AttributeController@ajaxAttributes')->name('goods.create');
    Route::get('/types/{type_id}/attributes/ajax_edit_attr','AttributeController@ajaxEditAttr')->name('goods.edit');

    //分类管理
    Route::get('/categories/dt_data','CategoryController@dtData')->name('categories.index');
    Route::resource('categories', 'CategoryController');
    //商品属性类型管理
    Route::get('/types/dt_data','TypeController@dtData')->name('types.index');
    Route::resource('types', 'TypeController');
    //商品属性管理
    Route::get('/types/{type_id}/attributes/dt_data','AttributeController@dtData')->name('attributes.index');
    Route::resource('types/{type_id}/attributes', 'AttributeController'); //route.name  attributes.index 依旧是只取结尾处


    /******************************系统设置区************************************/
    //权限管理
    Route::resource('permissions','PermissionController');
    //角色管理
    Route::get('/roles/dt_data','RoleController@dtData')->name('role.index');
    Route::resource('roles','RoleController');
    //管理员管理
    Route::get('/admins/dt_data','AdminController@dtData')->name('admin.index');
    Route::resource('admins','AdminController');
});