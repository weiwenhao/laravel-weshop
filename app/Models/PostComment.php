<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'content', 'obj_user_id', 'obj_username'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
