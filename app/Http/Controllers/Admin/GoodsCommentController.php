<?php

namespace App\Http\Controllers\Admin;

use App\Models\Goods;
use App\Models\GoodsComment;
use App\Models\GoodsCommentImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsCommentController extends Controller
{
    public function index($goods_id)
    {
        $goods = Goods::select('id', 'name')->find($goods_id);
        return view('admin.goods_comment.list', compact('goods'));
    }

    /**
     * @param $goods_id
     * @return mixed
     */
    public function dtData($goods_id)
    {
        $query = GoodsComment::where('goods_id', $goods_id);
        return \Datatables::of($query)->make(true);
    }

    public function destroy($goods_id, $comment_id)
    {
        $model = GoodsComment::find($comment_id);
        if (!$model)
            return response('资源不存在', 404);
        $model->removeGoodsCommentImage($model->id);
        $res = $model->delete();
        return (string) $res;
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

}
