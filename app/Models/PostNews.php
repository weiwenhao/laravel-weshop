<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostNews extends Model
{
    protected $guarded = ['read_at'];

    public function createCommentNews($post_comment)
    {
        $create_user_id = $post_comment->user_id;
        $author = $post_comment->Post->user_id; //文章的作者
        $post_id = $post_comment->post_id;

        if($post_comment->obj_user_id){ // 存在obj_user_id,代表回复评论 2
            if($create_user_id != $post_comment->obj_user_id){ //只要不是自己回复自己,那么被回复的一方始终可以收到
               //排除被回复人是作者,因为作者已经收到了评论提醒,不需要回复提醒了
                if($post_comment->obj_user_id != $author){
                    $this->create([ //回复提醒
                        'from_user_id' => $create_user_id,
                        'obj_user_id' => $post_comment->obj_user_id,
                        'post_id' => $post_id,
                        'type' => 2, //2 表示回复
                        'content' => str_limit($post_comment->content)
                    ]);
                }
            }
        }
        //只要不是评论的创建人不是帖子作者始终,那帖子的作者始终都可以收到 -> 您的帖子有新的评论
        if($create_user_id != $author ){
            $this->create([
                'from_user_id' => $create_user_id,
                'obj_user_id' => $author,
                'post_id' => $post_id,
                'type' => 1, //1 表示评论
                'content' => str_limit($post_comment->content)
            ]);
        }
    }

    public function createLikeNews($create_user_id, $post_id)
    {
        $post = Post::find($post_id);
        $author = $post->user_id; //帖子的作者
        if($create_user_id != $author) {
            //防止重复通知
            $new = $this->whereNull('read_at')
                ->where('from_user_id', $create_user_id)
                ->where('obj_user_id', $author)
                ->where('post_id', $post_id)
                ->where('type', 3)->first();
            if(!$new){
                $this->create([
                    'from_user_id' => $create_user_id,
                    'obj_user_id' => $author,
                    'post_id' => $post_id,
                    'type' => 3, //3代表点赞消息
                ]);
            }
        }
    }

    public function isNews($user_id)
    {
        $post_news_count = $this->where('obj_user_id', $user_id)->whereNull('read_at')->count();
        return $post_news_count;
    }

    public function getPostNews($request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 8);
        $order = $request->get('order', 'created_at');
        $sort = $request->get('sort', 'desc');

        $post_news = $this->select('post_news.from_user_id', 'users.username', 'users.logo',
            'posts.content as post_content', 'post_news.content', 'post_news.created_at', 'post_news.type', 'post_news.post_id')
            ->leftJoin('posts', function ($join){
                $join->on('posts.id', '=', 'post_news.post_id')
                    ->where('post_news.obj_user_id', '=', \Auth::user()->id);
            })
            ->join('users', 'users.id', '=', 'post_news.from_user_id')
            ->offset($offset)
            ->limit($limit)
            ->orderBy('posts.'.$order , $sort)
            ->get();
        $post_news = $this->transform($post_news);
        return $post_news;
    }

    private function transform($post_news)
    {
        $post_news = $post_news->map(function ($item){
            $item->content = nl2br(htmlspecialchars($item->content));
            $item->created_at_str = $item->created_at->format('m-d H:i');
            return $item;
        });
        return $post_news;
    }
}
