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
        $goods_img_name = md5(time().str_random(4)).'.jpg';
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
//        @unlink(public_path($this->image));
        @unlink(public_path($this->sm_image));  //商品小图不删除, 因为订单表中需要使用
//        @unlink(public_path($this->mid_image));
//        @unlink(public_path($this->big_image));
    }

    /**
     * 保存商品属性
     * @param $goods_id
     * @return array
     */
    public function saveGoodsAttr($goods_id){
        $goods_attr_ids = [];
        $attribute_values = request('attribute_values', []); //

        if(!$attribute_values) //先处理错误
            return $goods_attr_ids;

        foreach ($attribute_values as $attribute_id => $value) {
            $value = array_unique($value); //去重
            foreach ($value as $attribute_value){
                if($attribute_value){ //去空
                    //入库
                    $goods_attr_id = DB::table('goods_attributes')->insertGetId([ //应该执行了 sql过滤
                        'goods_id' => $goods_id,
                        'attribute_id' => $attribute_id,
                        'attribute_value' => $attribute_value,
                    ]);
                    $goods_attr_ids[] = $goods_attr_id;
                }
            }
        }
        return $goods_attr_ids;
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
        //批量插入数据库 todo 直接进行删除该商品下的所有商品属性,再进行有id的插入操作  这里会不会留下坑2333
        DB::table('goods_attributes')->where('goods_id', $goods_id)->delete();
        DB::table('goods_attributes')->insert($goods_attributes);

    }


    /**
     * 得到某件商品下的可选属性, 用于前台购买商品
     * @param $goods_id
     * @return static
     */
    public function getOptionGoodsAttr($goods_id)
    {
        $option_attr = DB::table('goods_attributes')
            ->select('goods.name', 'goods.id', 'attributes.name', 'goods_attributes.id as goods_attribute_id', 'goods_attributes.attribute_value')
            ->join('goods', function ($join) use($goods_id){
                $join->on('goods_attributes.goods_id', '=', 'goods.id')
                    ->where('goods.id', $goods_id);
            })
            ->join('attributes', 'goods_attributes.attribute_id', '=', 'attributes.id')
            ->where([
                ['attributes.type', '可选']
            ])
            ->get();
        return $option_attr->groupBy('name')->toArray();
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

        //得到分类id
        if(request('category_id')){
            $where[] = ['category_id', request('category_id')]; // 根据请求url中的  ?category_id=x 进行分类
        }
        $sort = request('sort', 'asc');
        $order = request('order', 'sort');
        if($order == 'buy_count'){
            $sort = 'desc'; //销量只有降序排列
        }

        $goods = $this->select('id', 'name', 'mid_image', 'price', 'buy_count', 'is_sale')
            ->where($where)
            ->where('is_deleted', 0)
            ->orderBy($order, $sort)
            ->paginate(config('shop.goods_list_count'));

        $category = Category::select('name')->findOrFail(request('category_id'));
        $goods->category_name = $category->name;
        return $goods;
    }

    /**
     * 根据用户的搜索得到商品数据
     * @return mixed
     */
    public function getGoodsByKey()
    {
        //初始值
        //初始值
        $key = request('key', '');

        $sort = request('sort', 'asc');
        $order = request('order', 'sort');
        if($order == 'buy_count'){
            $sort = 'desc'; //销量只有降序排列
        }



        $goods = $this->select('id', 'name', 'mid_image', 'price', 'buy_count', 'is_sale')
            ->where('is_deleted', 0) //不被删除的商品
            ->where('name', 'like', "%$key%")
            ->orderBy($order, $sort)
            ->paginate(config('shop.goods_list_count'));
        $goods->key = request('key');
        return $goods;
    }

    /**
     * 首页精品商品 没有被删除,且没有下架的商品才在首页显示
     * @param $limit
     * @return mixed
     */
    public function getBestGoods($limit){
        $goods = $this->select('id', 'name', 'mid_image', 'price', 'buy_count', 'is_sale')
            ->where('is_best', 1)
            ->where('is_deleted', 0)
            ->where('is_sale', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)->get();
        return $goods;
    }

    /**
     * 商品详情页的显示的评论
     * @return mixed
     */
    public function getFirstComment()
    {
        $goods_comment = GoodsComment::select('goods_comments.*', 'users.username', 'users.logo')
            ->join('users', 'users.id', '=', 'goods_comments.user_id')
            ->where('goods_id', $this->id)
            ->orderBy('goods_comments.created_at', 'desc')
            ->first();
        return $goods_comment;
    }

    /**
     * 页面下半部分的 猜你喜欢模块
     * @param $limit
     * @return
     */
    public function getLikeGoods($limit)
    {
        $goods = $this->select('id', 'name', 'mid_image', 'price', 'buy_count', 'is_sale')
            ->where('is_best', 1)
            ->where('is_deleted', 0)
            ->where('is_sale', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        return $goods;
    }
}
