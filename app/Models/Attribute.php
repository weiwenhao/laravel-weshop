<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [];
    //
    public function setOptionValues($option_values)
    {
        //统一逗号分隔符
        $option_values = str_replace('，', ',', $option_values);
        $option_values = explode(',', $option_values);
        //去重
        $option_values = array_unique($option_values);
        $temp_arr = [];
        foreach ($option_values as $v){ //去空
            if(trim($v)){
                $temp_arr[] = trim($v);
            }
        }
        $temp_arr = implode(',', $temp_arr);
        return $temp_arr;
    }

    public function ajaxAttrTransForm($attributes){
        $res = $attributes->map(function ($item) {
            //为数据添加 is_first_attr属性
            static $_box = '';
            if($item->name == $_box){ //代表已经进过盒子了
                //相等代表
                $item->is_first_attr = false;
            }else{
                $item->is_first_attr = true;
                //没有进过盒子
                $_box = $item->name;
            }
            //对attribute_value进行默认值处理
            if(!$item->attribute_value){
                $item->attribute_value = null;
            }
            if($item->option_values){
                $item->option_values = explode(',', $item->option_values);
            }
            return $item;
        });
        return $res;
    }

}
