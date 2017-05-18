<?php

Route::get('/test', function (){
   $post = \App\Models\Post::find(35);
   dd($post->postImages);
});



Route::get('/', function (){
    return redirect('/index');
});

Route::post('orders/notify', 'OrderController@notify'); //支付结果通知
Route::group(['middleware'=>['wechat.oauth:snsapi_userinfo'] ], function () {
    //商品区
    Route::get('index', 'GoodsController@index');
    Route::get('goods', 'GoodsController@list');
    Route::get('goods/number_price', 'GoodsController@GetPriceAndNumber');
    Route::get('goods/{goods_id}', 'GoodsController@show');
    //收藏区
    Route::post('collects/switch_collect', 'CollectController@switchCollect'); //服务于商品详情页
    Route::post('collects/collect', 'CollectController@collect');//服务于商品列表页
    Route::get('collects', 'CollectController@index');//服务于商品列表页
    Route::delete('collects/{id}', 'CollectController@noCollect');//服务于商品列表页

    //购物车
    Route::put('shop_carts', 'ShopCartController@editShopNumbers');
    Route::delete('shop_carts', 'ShopCartController@delShopCarts');
    Route::resource('shop_carts', 'ShopCartController');
    //地址管理
    Route::resource('addrs', 'AddrController');
    //订单管理
        //确认订单
    Route::get('orders/confirm/addrs', 'OrderController@addrs'); //确定订单中的地址列表
    Route::post('orders/confirm/addrs/{addr_id}', 'OrderController@setAddrId'); //确定订单中的地址列表
    Route::post('orders/shop_cart_confirm', 'OrderController@ShopCartToConfirm'); //将购物车商品经过结算操作转移到确认订单中
    Route::post('orders/goods_confirm', 'OrderController@GoodsToConfirm'); //将商品直接转移到确认订单中
    Route::get('orders/confirm', 'OrderController@confirm'); //确认订单
    //已经有订单id.根据改id再次付款
    Route::post('orders/repay', 'OrderController@repay');
    Route::resource('orders', 'OrderController');
    //个人中心
    Route::get('me', 'MeController@index'); //个人中心主页

    /******************圈子管理******************/
    //帖子管理
    Route::post('circles/upload', 'CircleController@upload');
    Route::resource('circles', 'CircleController');
    //帖子分类
    Route::get('api/post_categories', 'CircleController@ajaxCategories');
    Route::get('api/posts', 'CircleController@ajaxPosts');
    Route::delete('api/posts/{id}', 'CircleController@ajaxDestroy');
    Route::put('api/post_likes/{post_id}', 'CircleController@switchLikes');
    //帖子评论
    Route::post('api/post_comments', 'PostCommentController@Create');
    Route::delete('api/post_comments/{id}', 'PostCommentController@destroy');
});

/**
 * 后台登陆注册区
 */
Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {
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
        return redirect('/admin/compute');
    });
    /******************************控制台*********************************/
    //主页
//    Route::get('/index', 'IndexController@index');
    //统计区
    Route::get('/compute', 'ComputeController@compute');

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

    //商品库存管理
    Route::get('/goods/{goods_id}/numbers', 'NumberController@index')->name('numbers.index');
    Route::post('/goods/{goods_id}/numbers', 'NumberController@store')->name('numbers.edit');


    /******************************订单管理区************************************/
    //所有订单列表
    Route::get('/orders/dt_data','OrderController@dtData')->name('orders.index');
    Route::put('/orders', 'OrderController@handleOrder')->name('orders.edit');
    Route::resource('orders', 'OrderController');

    //水果订单列表(手机专享)
    Route::get('/fruit_orders/dt_data','FruitOrderController@dtData')->name('fruit_orders.index');
    Route::resource('/fruit_orders', 'FruitOrderController');


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

    /******************************活动管理**************************************/
    //活动列表
    Route::get('/actives/dt_data','ActiveController@dtData')->name('actives.index');
    Route::resource('actives', 'ActiveController');

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