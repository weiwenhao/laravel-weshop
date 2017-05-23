<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function saveCategoryLogo()
    {
        $path = config('shop.category_logo_path').date('Ymd').'/'; //图片的存储目录
        $logo_name = md5(time().str_random(4)).'.jpg'; //存储目录下的名称

        if(!is_dir(public_path($path)))
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        //or @mkdir(public_path($path), 0777, true);

        //进行图片的存储测试
        \Image::make(request('logo'))->fit(config('shop.category_logo_width'), config('shop.category_logo_height'))->save($path.$logo_name);

        return [
            'logo' =>  '/'.$path.$logo_name, //存储在数据库中的是一个可直接使用的图片路径
        ];

    }

    public function removeCategoryLogo()
    {
        @unlink(public_path($this->logo));
    }
}
