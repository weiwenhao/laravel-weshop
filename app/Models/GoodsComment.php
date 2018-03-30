<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsComment extends Model
{
    protected $guarded = [];


    public function goodsCommentImages()
    {
        return $this->hasMany(GoodsCommentImage::class, 'goods_comment_id', 'id');
    }

    public function removeGoodsCommentImage($goods_comment_id)
    {
        $images = GoodsCommentImage::where('goods_comment_id', $goods_comment_id)->get();
        if(!$images)return;
        foreach ($images as &$image){
            @unlink(public_path($image->image));
            @unlink(public_path($image->sm_image));
            $image->delete();
        }
    }

    public function getGoodsComment($goods_id, $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit');
        $goods_content = $this->with('goodsCommentImages')->select('goods_comments.*', 'users.username', 'users.logo')
                    ->join('users', 'users.id', '=', 'goods_comments.user_id')
                    ->where('goods_comments.goods_id', $goods_id)
                    ->orderBy('goods_comments.created_at', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
        $goods_content = $this->transform($goods_content);
        return $goods_content;
    }


    private function transform($goods_content)
    {
        $goods_content = $goods_content->map(function ($item){
            $item->content = nl2br(htmlspecialchars($item->content));
            $item->created_at_str = $item->created_at->format('H-m-d');
            return $item;
        });
        return $goods_content;
    }
}
