<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodsCommentRequest;
use App\Models\GoodsComment;
use App\Models\GoodsCommentImage;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Http\Request;

class GoodsCommentController extends Controller
{
    public function index($goods_id)
    {
        return view('goods_comment.list', compact('goods_id'));
    }


    public function create($order_goods_id)
    {
        $order_goods = OrderGoods::select('id', 'sm_image')->find($order_goods_id);
        return view('goods_comment.create', compact('order_goods'));
    }

    public function store(GoodsCommentRequest $request, $order_goods_id)
    {
        $order_goods = OrderGoods::where('id', $order_goods_id)->where('is_comment', 0)->first();
        if(!$order_goods){
            return response('订单不存在', 404);
        }
        $order = Order::where('user_id', \Auth::user()->id)->where('id', $order_goods->order_id)->first();
        if(!$order){
            return response('订单不存在', 404);
        }
        //入库操作
        $goods_comment = GoodsComment::create([
            'content' => $request->get('content'),
            'level' => $request->get('level'),
            'user_id' => \Auth::user()->id,
            'goods_id' => $order_goods->goods_id,
            'goods_attributes' => $order_goods->goods_attributes,
        ]);
        if($goods_comment){
            $order_goods->is_comment = 1;
            $order_goods->save();
        }
        return $goods_comment->id;
    }

    /**
     * 存储评论图片
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $goods_comment_id = $request->get('goods_comment_id');
        //图片存储
        $path = config('shop.goods_comment_img_path').date('Ymd').'/';
        $goods_comment_img_name =  md5(time().str_random(4)).'.jpg'; //当前时间精确到秒+4位随机数的MD5加密
        if(!is_dir(public_path($path))){
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        }

        //进行图片的存储测试
        \Image::make($request->file('goods_comment_img'))->save($path.$goods_comment_img_name);//原图存储, 考虑到前台已经进行了 0.8的质量压缩
        \Image::make($request->file('goods_comment_img'))
            ->fit($size = config('shop.sm_goods_comment_img_size'), $size)
            ->save($path.'sm_'.$goods_comment_img_name);

        $goods_comment_image = GoodsCommentImage::create([
            'goods_comment_id' => $goods_comment_id,
            'image' =>   '/'.$path.$goods_comment_img_name,
            'sm_image' => '/'.$path.'sm_'.$goods_comment_img_name,
        ]);
        return $goods_comment_image;
    }

    public function ajaxGoodsComments($goods_id, GoodsComment $goods_comment, Request $request)
    {
        $goods_comments = $goods_comment->getGoodsComment($goods_id, $request);
        return $goods_comments;
    }
}
