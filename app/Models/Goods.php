<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class Goods extends Model
{
    protected $guarded = ['id', '_token', 'attribute_values', 'goods_attribute_ids' ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saveGoodsImage()
    {
        //todo 设置图片比例
        $path = config('shop.goods_img_path').date('Ymd').'/';
        $goods_img_name = str_random().'.jpg';
        if(!is_dir(public_path($path))){
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        }
        //or @mkdir(public_path($path), 0777, true);
        //这里裁剪,再充值尺寸

        //进行图片的存储测试
        Image::make(request('image'))->fit($size = config('shop.goods_img_size'), $size)->save($path.$goods_img_name);
        Image::make(request('image'))->fit($size = config('shop.sm_goods_img_size'), $size)->save($path.'sm_'.$goods_img_name);
        Image::make(request('image'))->fit($size = config('shop.mid_goods_img_size'), $size)->save($path.'mid_'.$goods_img_name);
        Image::make(request('image'))->fit($size = config('shop.big_goods_img_size'), $size)->save($path.'big_'.$goods_img_name);

        return [
          'image' =>  '/'.$path.$goods_img_name,
          'sm_image' =>  '/'.$path.'sm_'.$goods_img_name,
          'mid_image' =>  '/'.$path.'mid_'.$goods_img_name,
          'big_image' =>  '/'.$path.'big_'.$goods_img_name,
        ];

    }

    public function removeGoodsImage()
    {
        @unlink(public_path($this->image));
        @unlink(public_path($this->sm_image));
        @unlink(public_path($this->mid_image));
        @unlink(public_path($this->big_image));
    }

    /**
     * 保存商品属性
     * @param $goods_id
     * return void
     */
    public function saveGoodsAttr($goods_id){
        $attribute_values = request('attribute_values', []); //
        foreach ($attribute_values as $attribute_id => $value) {
            $value = array_unique($value); //去重
            foreach ($value as $attribute_value){
                if($attribute_value){ //去空
                    //入库
                    DB::table('goods_attributes')->insert([ //应该执行了 sql过滤
                        'goods_id' => $goods_id,
                        'attribute_id' => $attribute_id,
                        'attribute_value' => $attribute_value,
                    ]);
                }
            }
        }
    }

    /**
     * 后台修改商品属性
     * @param $goods_id
     */
    public function editGoodsAttr($goods_id){
        $attribute_values = request('attribute_values', []); // attribute_id => attribute_value
        $goods_attribute_ids = request('goods_attribute_ids');
        //$goods_attribute_values
        //拼凑入库数组
        $goods_attributes = [];
        $count = 0;
        foreach ($attribute_values as $attribute_id => $value){
            foreach ($value as $key => $attribute_value){
                if($attribute_value){//去null
                    //判断的应该是一个值在数组总出现的次数超过两次?
                    if($this->arrayCount($attribute_value ,$value) < 2 || $goods_attribute_ids[$count]){
                        //去重已成功
                        $goods_attributes[] = [
                            'id' => $goods_attribute_ids[$count],
                            'goods_id' => $goods_id,
                            'attribute_id' => $attribute_id,
                            'attribute_value' => $attribute_value
                        ];
                    }else{
                        //这里是不满足条件的重复数据,进行unset操作
                        unset($value[$key]);
                    }
                }
                $count ++;
            }
        }
        //批量插入数据库 todo 直接进行删除该商品下的所有商品属性,再进行有id的插入操作
        DB::table('goods_attributes')->where('goods_id', $goods_id)->delete();
        DB::table('goods_attributes')->insert($goods_attributes);
        //方法2,进行数据库查询插入

    }

    /**
     * 得值在数组中出现的次数,包括null
     * @param $needle
     * @param $haystak
     * @return int
     */
    private function arrayCount($needle, $haystak){
        $count = 0;
        foreach($haystak as $value){
            if($needle == $value){
                $count ++;
            }
        }
        return $count;
    }

    public function getGoodsByCid()
    {
        //初始值
        $where = [];
        $order = 'id';
        $sort = 'desc';
        //得到分类id
        if(request('category_id')){
            $where[] = ['category_id', request('category_id')];
        }
        if(request('order')){
            $order = request('order');
        }
        if(request('sort')){
            $sort = request('sort');
        }
        $goods = $this->where($where)->orderBy($order, $sort)->paginate(15);
        return $goods;
    }

    public function getGoodsByKey()
    {
        //初始值
        $order = 'id';
        $sort = 'desc';
        $key = request('key');
        if(request('order')){
            $order = request('order');
        }
        if(request('sort')){
            $sort = request('sort');
        }
        $goods = $this->where(['name', 'like', "%$key%"])->orderBy($order, $sort)->paginate(15);
        return $goods;
    }

    public function getBestGoods($limit){
        $goods = $this->select('id', 'name', 'sm_image', 'price')->where('is_best', 1)->limit($limit)->get();
        return $goods;
    }
}
