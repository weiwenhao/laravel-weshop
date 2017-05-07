<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Goods;
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
        $actives = $active->getActives(); //画布导航数据
        $best_goods = $goods->getBestGoods(10);
        return view('goods.index', compact('actives', 'best_goods'));
    }
    /**
     *商品详情页
     * @param $goods_id
     * @param Goods $goods
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($goods_id, Goods $goods)
    {
        $goods = Goods::findOrFail($goods_id);
        $goods->option_attrs = $goods->getOptionGoodsAttr($goods->id);
        return view('goods.goods', compact('goods'));
    }


    /**
     * @param Goods $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Goods $model)
    {
        if(request('category_id')){
            $goods = $model->getGoodsByCid();
        }elseif(request('key')){
            $goods = $model->getGoodsByKey();
        }
        return view('goods.list', compact('goods'));
    }
}
