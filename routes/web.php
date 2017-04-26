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

Route::get('/test', function (\EasyWeChat\Foundation\Application $wechat){
 // odh7zsgI75iT8FRh0fGlSojc9PWM
//    dd($wechat->user->get('ojRsVv5u3iizG1Qf7XyKKtajcDSA'));
//    dd(Auth::guard('admin')->user());
//    $message = new \EasyWeChat\Message\Text(['content' => '测试消息']);
//    $wechat->staff->message($message)->to('ojRsVv5u3iizG1Qf7XyKKtajcDSA')->send();
//    dd(session('wechat.oauth_user'));

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
Route::group(['prefix' => 'admin', 'namespace'=>'Admin', 'middleware'=>['auth.admin','check.admin', /*'wechat.oauth:snsapi_userinfo'*/] ], function () {
    Route::get('/',function (){
        return view('admin.index');
    });

    /******************************商品管理区************************************/
    //商品管理
    Route::get('/goods/dt_data','GoodsController@dtData')->name('goods.index'); //定义路由名称和resource的index一致,方便对权限进行判断
    Route::resource('goods', 'GoodsController');
    Route::get('/types/ajax_types','TypeController@ajaxTypes')->name('goods.create');
    Route::get('/types/{type_id}/attributes/ajax_attributes','AttributeController@ajaxAttributes')->name('goods.create');
    Route::get('/types/{type_id}/attributes/ajax_edit_attr','AttributeController@ajaxEditAttr')->name('goods.edit');
    Route::delete('/goods_attributes/{id}', 'GoodsController@delGoodsAttr')->name('goods.edit');

    //分类管理
    Route::get('/categories/dt_data','CategoryController@dtData')->name('categories.index');
    Route::resource('categories', 'CategoryController');
    //商品属性类型管理
    Route::get('/types/dt_data','TypeController@dtData')->name('types.index');
    Route::resource('types', 'TypeController');
    //商品属性管理
    Route::get('/types/{type_id}/attributes/dt_data','AttributeController@dtData')->name('attributes.index');
    Route::resource('types/{type_id}/attributes', 'AttributeController'); //route.name  attributes.index 依旧是只取结尾处

    /******************************订单管理区************************************/
    //订单列表
    Route::get('/orders/dt_data','OrderController@dtData')->name('orders.index');
    Route::put('/orders', 'OrderController@handleOrder')->name('orders.edit');
    Route::resource('orders', 'OrderController');
    //地址列表
    Route::get('/addrs/dt_data','AddrController@dtData')->name('addrs.index');
    Route::get('/addrs', 'AddrController@index')->name('addrs.index');
    Route::delete('/addrs/{id}', 'AddrController@destroy')->name('addrs.destroy');

    /******************************圈子管理**************************************/
    //说说列表
    Route::get('posts/dt_data','PostController@dtData')->name('posts.index');
    Route::resource('posts', 'PostController', ['only' => ['index', 'destroy']]);
    //评论列表
    Route::get('posts/{post_id}/post_comments/dt_data','PostCommentController@dtData')->name('comments.index');
    Route::resource('posts/{post_id}/post_comments', 'PostCommentController', ['only' => ['index', 'destroy']]);

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