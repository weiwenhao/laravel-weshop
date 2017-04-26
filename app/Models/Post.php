<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    //一篇文章多张相片
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }
}
