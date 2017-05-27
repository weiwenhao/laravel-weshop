<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Category;
use App\Models\Collect;
use App\Models\Goods;
use App\Models\GoodsComment;
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
        $goods = Goods::where('id', $goods_id)->where('is_deleted', 0)->first();
        if($goods){
            //添加一个收藏状态
            $collect = Collect::where('goods_id', $goods->id)->where('user_id', \Auth::user()->id)->first();
            $collect?$goods->is_collect=true:$goods->is_collect=false;
            //添加可选属性
            $goods->option_attrs = $goods->getOptionGoodsAttr($goods->id);

            //该商品总评价数量
            $goods_comment = $goods->getFirstComment();
        }
        return view('goods.goods', compact('goods', 'goods_comment'));
    }

    public function goodsDesc($goods_id)
    {
        $goods = Goods::select('id', 'description', 'price')->where('id', $goods_id)->first();
        return view('goods.desc', compact('goods'));
    }

    /**
     * @param Goods $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Goods $model)
    {
        if(request('category_id')){
            $goods = $model->getGoodsByCid();// todo 这里可以考虑从新return view
        }elseif(request('key')){
            $goods = $model->getGoodsByKey();
        }

        return view('goods.list', compact('goods'));
    }

    public function getPriceAndNumber(Request $request)
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

    public function getCategories()
    {
        $categories = Category::where('is_show', 1)->orderBy('sort', 'asc')->get();
        return view('goods.category_list', compact('categories'));
    }
}
