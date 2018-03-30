<?php

namespace App\Http\ViewComposers;

use App\Models\Goods;
use Illuminate\View\View;

class LikeGoodsComposer
{

    private $goods;

    /**
     * AdminComposer constructor.
     * @param Goods|Application $goods
     */
    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }

    public function compose(View $view)
    {
        //菜单数据.用于左侧菜单栏
       $like_goods = $this->goods->getLikeGoods(config('shop.like_goods_count', 8));
        $view->with(compact('like_goods')); // compact('menus) == ['menus'=>$menus]
    }
}