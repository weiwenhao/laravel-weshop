<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Collect;
use App\Models\Goods;
use App\Models\Order;
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
        \Cookie::queue('orders_previous_url', \request()->getUri());

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

        $goods = Goods::where('id', $goods_id)->where('is_deleted', 0)->first();
        if($goods){
            //添加一个收藏状态
            $collect = Collect::where('goods_id', $goods->id)->where('user_id', \Auth::user()->id)->first();
            $collect?$goods->is_collect=true:$goods->is_collect=false;
            //添加可选属性
            $goods->option_attrs = $goods->getOptionGoodsAttr($goods->id);
        }
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

    public function GetPriceAndNumber(Request $request)
    {
        $goods_id = $request->get('goods_id');
        $number_price = Goods::select( 'goods.price as goods_price',
            'numbers.goods_attribute_ids', 'numbers.number', 'numbers.price')
            ->Join('numbers', 'goods.id', '=', 'numbers.goods_id')
            ->where('goods.id', $goods_id)
            ->get();
        //数据处理方便取出
        $number_price = $number_price->keyBy(function ($item){
            //返回的值将作为键值使用
            return 'a'.str_replace(',', '_', $item->goods_attribute_ids);
        });
        return $number_price;
    }
}
