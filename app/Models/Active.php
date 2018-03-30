<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;

class Active extends Model
{
    protected $guarded = ['id'];

    public function saveActiveImage()
    {
        $path = config('shop.active_img_path').date('Ymd').'/'; //目录已天数做分隔
        $active_img_name = str_random().'.jpg';
        if(!is_dir(public_path($path))){
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        }
        //or @mkdir(public_path($path), 0777, true);
        //这里裁剪,再充值尺寸

        //进行图片的存储测试
        Image::make(request('image'))->fit(config('shop.active_img_width'), config('shop.active_img_height'))
            ->save($path.$active_img_name); //save默认保存在public目录下

        return [
            'image' =>  '/'.$path.$active_img_name,
        ];

    }

    public function removeActiveImage()
    {
        @unlink(public_path($this->image));
    }

    public function getActives()
    {
        //根据设置中的数量取出封面封面,不包含商品详情
        $actives = $this->select('id', 'name', 'url', 'image', 'sort', 'is_content')
            ->where('is_show', 1)
            ->orderBy('sort', 'asc')
            ->limit(config('shop.active_img_count'))
            ->get();
        return $actives;
    }
}
