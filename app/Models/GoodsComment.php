<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsComment extends Model
{
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
}
