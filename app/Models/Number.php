<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $guarded = [];


    /**
     * 后台修改商品时调用该方法进行库存量的修改
     * @param $goods
     */
    public function editNumbers($goods)
    {
        /**
         * 情况分析
         * 情况1:  原来库存表中 只要一条 goods_attribute_ids=null的数据,现在增加数据
         * 情况2:  原来库存表中有很多条数据, 但是现在需要去掉属性,只加一条 goods_attribute_ids=null
         * 情况3:  原来的属性都是手机的,现在变成了水果的属性 ->既type_id的变动  ->将编辑商品处的type_id的变动设置为禁止即可!
         * 情况4:  比原来的排列组合后更多了
         * 情况5:  比原来的排列组合后变得不同了,有多有少
         */
        //根据当前属性表得到goods_attributes_ids_list
        $ga_GAIL = $this->getGAIL($goods->id);
        if(!$ga_GAIL){ //如果 ga_GAIL的值为空, 则代表上述情况2, 填充一条""用来实现求 数组元素不同时计算到 "",才能实现填充""
            $ga_GAIL = [""];
        }
//        dump($ga_GAIL);
        //得到库存表总的GAIL
        $nm_GAIL = $this->where('goods_id', $goods->id)->get();
        $nm_GAIL = $nm_GAIL->pluck('goods_attribute_ids')->toArray();
//        dump($nm_GAIL);
        //求两个数组中的不同项
        $diff_arr =  array_merge(array_diff($ga_GAIL, $nm_GAIL), array_diff($nm_GAIL,$ga_GAIL));
//        dump($diff_arr);
        //如果差集为存在
        if($diff_arr){
            foreach ($diff_arr as $goods_attribute_ids){
                if(in_array($goods_attribute_ids, $ga_GAIL, true)){
                    //如果goods_attr_ids只属于新排列组合则新创建
                    $this->create([
                        'goods_attribute_ids' => $goods_attribute_ids,
                        'goods_id' => $goods->id,
                        'number' => config('shop.default_goods_number'),
                    ]);
                }else{
                    //存在于number表中,但是却不存在于新的排列组合中,说明该商品的该存储属性为脏数据,应该删除
                    $where = [
                        ['goods_id', $goods->id],
                        ['goods_attribute_ids', $goods_attribute_ids]
                    ];
                    $this->where($where)->delete();
                    //todo 删除库存表的同时购物车中含有该数据的商品
                    ShopCart::where($where)->delete();
                }
            }
        }

    }



    /**
     * @param $goods
     * @return void
     */
    public function createNumbers(Goods $goods)
    {
        $goods_attribute_ids_list = $this->getGAIL($goods->id);
        if(!$goods_attribute_ids_list){
            //创建一条goods_attribute_ids = ''的数据
            Number::create([
                'number' => config('shop.default_goods_number'),
                'goods_id' => $goods->id,
            ]);
        }else{
            foreach ($goods_attribute_ids_list as $goods_attribute_ids){
                Number::create([
                    'goods_attribute_ids' => $goods_attribute_ids,
                    'goods_id' => $goods->id,
                    'number' => config('shop.default_goods_number'),
                ]);
            }
        }
    }

    /**
     * 得到商品属性的各种排列组合
     * @param $goods_id
     * @return array|  []  or [ ['1,2','3,4'....]]
     */
    protected function getGAIL($goods_id)
    {
        $goods_attributes = \DB::table('goods_attributes')
            ->select('goods_attributes.id as goods_attribute_id', 'goods_attributes.attribute_value', 'attributes.id as attribute_id')
            ->join('attributes', function ($join) use($goods_id){
                $join->on('goods_attributes.attribute_id', '=', 'attributes.id')
                    ->where('attributes.type', '可选')
                    ->where('goods_attributes.goods_id', '=',$goods_id);
            })
            ->get();
        if(!$goods_attributes->toArray()) //如果商品属性表中没有该商品的属性返回空数组
            return [];

        $goods_attributes = $goods_attributes->groupBy('attribute_id');
        $goods_attributes = $goods_attributes->map(function ($item){ //得到goods_attribute_ids的未排列数组
            $item = $item->pluck('goods_attribute_id');
            return $item;
        });
        return $this->groupAndSort($goods_attributes->toArray()); //二维数组所有的排列组合,未进行升降序处理
    }

    /**
     * 对数组进行排列组合,并对数组中的每一项进行排序, 仅支持数字数组
     * @param array $arr
     * @return array|mixed
     */
    protected function groupAndSort(array $arr){
        if(count($arr) == 1){
            //单个排序处理
            $arr = current($arr);
            sort($arr, SORT_NUMERIC);
            return $arr;
        }
        $arr =  current($this->group($arr));
        foreach ($arr as &$value){
            $value = explode(',', $value);
            sort($value);
            $value =implode(',', $value);
        }
        return $arr;
    }

    /**
     * 对二维数组进行递归排列组合,支持各种数据类型
     * 排序前
     * [
     *  [1,2,3]
     *  [4,5,6]
     * ]
     * 排序后
     * [
     *     ['1,4', '1,5', '1,6' ,'2,4', '2,5', '2,6', '3,4', '3,5', '3,6']
     * ]
     *
     * @param $arr  至少需要两个元素
     * @return mixed
     */
    protected function group($arr)
    {
        if(count($arr) >= 2){
            //推出两个进行排列
            $arr1 = array_shift($arr);
            $arr2 = array_shift($arr);
            $temp_arr = [];
            foreach ($arr1 as $v1){
                foreach ($arr2 as $v2){
                    $temp_arr[] = $v1.','.$v2;
                }
            }
            array_unshift($arr, $temp_arr);
            $arr = $this->group($arr); //这里最后一次出来之后,不可能在进else一次, 而是直接走到最后的return $arr
        }else{
            return $arr;
        }
        return $arr;
    }

}
