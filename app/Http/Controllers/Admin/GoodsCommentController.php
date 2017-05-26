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

}
