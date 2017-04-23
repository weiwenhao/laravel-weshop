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
}
