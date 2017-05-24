<?php

Route::get('/test', function (){

});



Route::get('/', function (){
    return redirect('/index');
});

Route::post('orders/notify', 'OrderController@notify'); //支付结果通知
Route::group(['middleware'=>['wechat.oauth:snsapi_userinfo'] ], function () {
    //商品区
    Route::get('index', 'GoodsController@index')->middleware(['exit_url_in:goods_info', 'exit_url_in:orders', 'exit_url_in:goods']);
    Route::get('goods', 'GoodsController@list')->middleware(['exit_url_in:goods_info']);
    Route::get('goods/categories', 'GoodsController@getCategories')->middleware(['exit_url_in:goods']);//商品分类
    Route::get('goods/number_price', 'GoodsController@getPriceAndNumber'); //ajax
    Route::get('goods/{goods_id}', 'GoodsController@show')->middleware(['exit_url_in:confirm']);

    //活动详情
    Route::get('actives/{actives_id}', 'ActiveController@show');
    //收藏区
    Route::get('collects', 'CollectController@index')->middleware(['exit_url_in:goods_info']);
    Route::post('collects/switch_collect', 'CollectController@switchCollect');
    Route::post('collects/collect', 'CollectController@collect');

    Route::delete('collects/{id}', 'CollectController@noCollect');

    //购物车
    Route::get('shop_carts', 'ShopCartController@index')->middleware(['exit_url_in:goods_info', 'exit_url_in:confirm']);
    Route::post('shop_carts', 'ShopCartController@store');
    Route::put('shop_carts', 'ShopCartController@editShopNumbers');
    Route::delete('shop_carts', 'ShopCartController@delShopCarts');

    //地址管理
    Route::resource('addrs', 'AddrController');
    //订单管理
        //确认订单
    Route::get('orders/confirm/addrs', 'OrderController@addrs')->middleware(['exit_url_in:addrs']); //确定订单中的地址列表
    Route::post('orders/confirm/addrs/{addr_id}', 'OrderController@setAddrId');
    Route::post('orders/shop_cart_confirm', 'OrderController@ShopCartToConfirm'); //将购物车商品经过结算操作转移到确认订单中
    Route::post('orders/goods_confirm', 'OrderController@GoodsToConfirm'); //将商品直接转移到确认订单中
    Route::get('orders/confirm', 'OrderController@confirm'); //确认订单
    //已经有订单id.根据改id再次付款
    Route::post('orders/repay', 'OrderController@repay');
    Route::resource('orders', 'OrderController');\

    //个人中心
    Route::get('me', 'MeController@index')->middleware(['exit_url_in:addrs', 'exit_url_in:orders']); //个人中心主页

    /******************圈子管理******************/
    //帖子管理
    Route::get('posts', 'PostController@index');
    Route::get('posts/create', 'PostController@create');
    Route::get('posts/{post_id}', 'PostController@show');
    //圈子api管理
    Route::post('api/posts/upload', 'PostController@upload');
    Route::post('api/posts', 'PostController@postStore');
    Route::get('api/post_categories', 'PostController@ajaxCategories');
    Route::get('api/posts', 'PostController@ajaxPosts');
    Route::get('/api/posts/user', 'PostController@ajaxUser');
    Route::get('api/posts/{post_id}', 'PostController@ajaxPost');
    Route::delete('api/posts/{post_id}', 'PostController@ajaxDestroy');
    Route::put('api/post_likes/{post_id}', 'PostController@switchLikes');
    //帖子评论
    Route::post('api/post_comments', 'PostCommentController@Create');
    Route::delete('api/post_comments/{id}', 'PostCommentController@destroy');
    //帖子消息
    Route::get('post_news', 'PostNewsController@index');
    Route::get('api/post_news', 'PostNewsController@ajaxPostNews');
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
    Route::get('/deled_goods', 'GoodsController@deledGoods')->name('goods.index');
    Route::get('/deled_goods/deled_goods_dt_data','GoodsController@deledGoodsdtData')->name('goods.index');
    Route::put('/deled_goods/refresh/{id}', 'GoodsController@refreshGoods')->name('goods.edit');

    Route::get('/goods/dt_data','GoodsController@dtData')->name('goods.index'); //定义路由名称和resource的index一致,方便对权限进行判断
    Route::put('/goods/is_sale', 'GoodsController@updateIsSale')->name('goods.edit');
    Route::resource('goods', 'GoodsController');
        //商品评价


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
    Route::post('/goods/{goods_id}/numbers', 'NumberController@store')->name('numbers.index');
    //商品
    Route::get('/goods/{goods_id}/goods_comments', 'GoodsCommentController@index')->name('goods_comments.index');
    Route::get('/goods/{goods_id}/goods_comments/dt_data', 'GoodsCommentController@dtData')->name('goods_comments.index');
    Route::delete('/goods/{goods_id}/goods_comments/{id}', 'GoodsCommentController@destroy')->name('goods_comments.destroy');

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
    //板块管理
    Route::get('/post_categories/dt_data','PostCategoryController@dtData')->name('post_categories.index');
    Route::resource('post_categories', 'PostCategoryController');

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