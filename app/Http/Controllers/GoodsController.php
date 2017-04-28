<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Goods;
use App\Models\User;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    /*
     * 前台首页
     */
    public function index(Goods $goods, Active $active)
    {
//        $user = User::find(session('wechat.oauth_user')->id);
        $actives = $active->getActives();
        dd($actives);
        $best_goods = $goods->getBestGoods(10);
    }


    /**
     * 根据分类id得到的商品列表页
     *商品列表页
     * @param Goods $goods
     */
    public function listByCid(Goods $goods)
    {
        $goods = $goods->getGoodsByCid();
        //分页
    }

    /**
     * 根据搜索得到的商品列表
     */
    public function listByKey(Goods $goods)
    {
        $goods = $goods->getGoodsByKey();
    }

    /**
     *商品详情页
     */
    public function desc()
    {

    }
}
