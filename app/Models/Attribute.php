<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [];
    //
    public function setOptionValuesAttribute($value)
    {
        //统一逗号分隔符
        $this->attributes['option_values'] =  str_replace('，', ',', $value);;
    }
    public function ajaxAttrTransForm($attributes){
        return $attributes->map(function ($item) {
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
    }

}
