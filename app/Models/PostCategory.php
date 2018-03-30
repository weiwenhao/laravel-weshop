<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PostCategory extends Model
{
    protected $guarded = [];

    /**
     * 定义闭包全局作用域, 板块排列安卓sort升序排列
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sort', function(Builder $builder) {
            $builder->orderBy('sort', 'asc');
        });
    }
}
