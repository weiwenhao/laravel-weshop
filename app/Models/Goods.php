<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class Goods extends Model
{
    protected $guarded = ['id'];

    public function saveGoodsImage()
    {
        //todo 设置图片比例
        $path = config('shop.goods_path').date('Ymd').'/';
        $goods_name = str_random().'.jpg';
        if(!is_dir(public_path($path))){
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        }
        //or @mkdir(public_path($path), 0777, true);
        //这里裁剪,再充值尺寸

        //进行图片的存储测试
        Image::make(request('image'))->fit($size = config('shop.goods_img_size'), $size*3/5)->save($path.$goods_name);
        Image::make(request('image'))->fit($size = config('shop.sm_goods_img_size'), $size*3/5)->save($path.'sm_'.$goods_name);
        Image::make(request('image'))->fit($size = config('shop.mid_goods_img_size'), $size*3/5)->save($path.'mid_'.$goods_name);
        Image::make(request('image'))->fit($size = config('shop.big_goods_img_size'), $size*3/5)->save($path.'big_'.$goods_name);

        return [
          'image' =>  '/'.$path.$goods_name,
          'sm_image' =>  '/'.$path.'sm_'.$goods_name,
          'mid_image' =>  '/'.$path.'mid_'.$goods_name,
          'big_image' =>  '/'.$path.'big_'.$goods_name,
        ];

    }

    public function removeGoodsImage()
    {
        @unlink(public_path($this->image));
        @unlink(public_path($this->sm_image));
        @unlink(public_path($this->mid_image));
        @unlink(public_path($this->big_image));
    }
}
