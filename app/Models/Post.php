<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    //一篇文章多张相片
    public function postImages()
    {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function getPosts($request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 8);
        $order = $request->get('order', 'created_at');
        $sort = $request->get('sort', 'desc');
        $where = [];
        if($post_category_id = $request->get('post_category_id')){
            $where[] = ['post_category_id', $post_category_id];
        }
        $posts = $this->select('posts.id', 'posts.content', 'posts.post_category_id', 'posts.created_at',
            'posts.likes_count', 'users.username', 'users.id as user_id', 'users.logo', 'post_categories.name as post_category_name')
            ->with('postImages')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->offset($offset)
            ->limit($limit)
            ->orderBy('posts.'.$order , $sort)
            ->where($where)
            ->get();
        $posts = $this->transform($posts);
        return $posts;

    }

    public function transform($posts)
    {
        $res = $posts->map(function ($item){
            $item->content = nl2br(htmlspecialchars($item->content));
//            dd($item->created_at->format('m-d H:i'));
            $item->created_at_str = $item->created_at->format('m-d H:i');
            return $item;
        });
        return $res;
    }
}
