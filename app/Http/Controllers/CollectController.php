<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    public function index()
    {
        $collects = Collect::select('goods.id as goods_id', 'goods.name as goods_name', 'goods.price as goods_price',
            'goods.sm_image', 'collects.id'
            )
            ->join('goods', function ($join){
                $join->on('goods.id', '=', 'collects.goods_id');
            })
            ->where('user_id', \Auth::user()->id)->paginate(config('shop.collects_count'));
        return view('collect.list', compact('collects'));
    }

    /**
     * 收藏与取消收藏状态之间的切换
     * @param Request $request
     * @return mixed
     */
    public function switchCollect(Request $request)
    {
        $goods_id = $request->get('goods_id');
        //判断该用户是否收藏了该商品
        $collect = Collect::where('goods_id', $goods_id)->where('user_id', \Auth::user()->id)->first();
        if(!$collect){
            $collect = new Collect();
            return $collect->collect($goods_id);
        }
        return $collect->cancelCollect($goods_id);
    }

    public function collect(Request $request)
    {
        $goods_id = $request->get('goods_id');
        //判断该用户是否收藏了该商品
        $collect = Collect::where('goods_id', $goods_id)->where('user_id', \Auth::user()->id)->first();
        if(!$collect){
            $collect = new Collect();
            $collect->collect($goods_id);
        }
        return response('收藏成功', 200);
    }

    /**
     * ajax取消关注 服务于我的收藏页面
     * @param $id
     * @return void
     */
    public function noCollect($id)
    {
        Collect::where('id', $id)->where('user_id', \Auth::user()->id)->delete();
    }
    
}
