<?php
return [
    //商品各个图片尺寸,
    'goods_img_path'    =>  'uploads/images/goods/', //默认在public目录下
    'goods_img_size' => 800,
    'sm_goods_img_size' => 100, //购物车图
    'mid_goods_img_size' => 200, //商品列表图
    'big_goods_img_size' => 400, //商品详情页图
    //商品评论图片
    'goods_comment_img_path' => 'uploads/images/goods_comment/',
    'sm_goods_comment_img_size' => 170, //略缩图边长 px

    //分类名称图片
    'category_logo_path' => 'uploads/images/category/',
    'category_logo_width' => 400,
    'category_logo_height' => 200,

    //活动封片的尺寸 250 x 160
    'active_img_path'   => 'uploads/images/active/',
    'active_img_width' => 380,
    'active_img_height' => 235,
    'active_img_count' => 3, //前台活动封面显示个数

    'goods_list_count' => 8, //商品列表页 每页显示的商品数量
    'default_goods_number' => 9999, //默认商品库存量
    'like_goods_count' => 6,
    'collects_count' => 8, //收藏列表显示的记录数

    //圈子图片保存路径
    'post_img_path' =>  'uploads/images/post/', //默认在public目录下
    'sm_post_img_size' => 170,
];