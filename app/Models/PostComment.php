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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /*public function objUser()
    {
        return $this->belongsTo(User::class, 'obj_user_id', 'id');
    }*/
}
