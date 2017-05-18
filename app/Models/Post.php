<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    /**
     * 一篇文章多张配图
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postImages()
    {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    /**
     * 一篇文章的多个评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postComments()
    {
        $post_comments = $this->hasMany(PostComment::class, 'post_id', 'id');
        $post_comments->select('post_comments.*', 'users.username')->join('users', 'users.id', '=', 'post_comments.user_id')->orderBy('created_at', 'asc');
        //添加一个是否为作者的判断
        return $post_comments;
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function userLikes()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id');
    }



    /*****************************可调用方法区域******************************/

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
            /*'posts.likes_count',*/ 'users.username', 'users.id as user_id', 'users.logo', 'post_categories.name as post_category_name',
            'post_likes.user_id as is_like'
            )
            ->with('postImages', 'postComments')
            ->withCount('postComments')
            ->withCount('userLikes')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('post_categories', 'post_categories.id', '=', 'posts.post_category_id')
            ->leftJoin('post_likes', function ($join){ //判断当前用户是否点赞了该帖子 结合上面的  post_likes.user_id as is_like
                $join->on('posts.id', '=', 'post_likes.post_id')
                    ->where('post_likes.user_id', \Auth::user()->id);
            })
            ->offset($offset)
            ->limit($limit)
            ->orderBy('posts.'.$order , $sort)
            ->where($where)
            ->get();
        $posts = $this->transform($posts);
        return $posts;
    }

    private function transform($posts)
    {
        $res = $posts->map(function ($item){
            $item->content = nl2br(htmlspecialchars($item->content));
            $item->created_at_str = $item->created_at->format('m-d H:i');
            //当前用户是否为当前帖子的作者
            $item->is_author = \Auth::user()->id == $item->user_id;
            //当前用户是否点赞过该篇帖子
//            $item->is_like = $this->isLike($item);
            //帖子评论信息
            $item->post_comments = $this->commentTransform($item->postComments);
            return $item;
        });
        return $res;
    }

    private function commentTransform($postComments)
    {
        $postComments = $postComments->map(function ($item){
            $item->is_author = $item->user_id == \Auth::user()->id;
            return $item;
        });
        return $postComments;
    }

    /**
     * 删除帖子的同时删除帖子对应的图片
     * @param $post_id
     */
    public function delImage($post_id)
    {
        $post_images = PostImage::where('post_id', $post_id)->get();
        foreach ($post_images as &$post_image){ //引用传递,常驻在内存中
            @unlink(public_path($post_image->image));
            @unlink(public_path($post_image->sm_image));
            $post_image->delete();
        }
    }

    private function isLike($post)
    {
        //得到被点赞的所有人? 然后判断当前用户是否在这些人里面?
    }
}
