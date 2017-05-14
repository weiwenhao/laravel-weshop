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
        //session记录一下当前url方便存储 todo 待重构为cookie,或者中间件
        \Cookie::queue('goods_previous_url', \request()->getUri());

        $actives = $active->getActives(); //画布导航数据
        $best_goods = $goods->getBestGoods(8);
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
        //确认订单的上一页进行记录 todo 待重构为中间件
        session(['confirm_previous_url' => \request()->getUri()]);
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
        //session记录一下当前url方便存储 todo 待重构为cookie,或者中间件
        \Cookie::queue('goods_previous_url', \request()->getUri());

        if(request('category_id')){
            $goods = $model->getGoodsByCid();// todo 这里可以考虑从新return view
        }elseif(request('key')){
            $goods = $model->getGoodsByKey();
        }
        return view('goods.list', compact('goods'));
    }
}
