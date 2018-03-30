<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentRequest;
use App\Models\PostComment;
use App\Models\PostNews;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function create(PostCommentRequest $request, PostNews $post_news)
    {
        $post_comment = PostComment::create([
            'user_id' => \Auth::user()->id,
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content'),
            'obj_user_id' => (int)$request->get('obj_user_id'),
            'obj_username' => (string) $request->get('obj_username')
        ]);

        //评论成功创建消息提醒
        if($post_comment)
            $post_news->createCommentNews($post_comment);

        //transform
        $post_comment->username = \Auth::user()->username;
        $post_comment->logo = \Auth::user()->logo;
        $post_comment->created_at_str = $post_comment->created_at->format('m-d H:i');
        //评论内容换行
        $post_comment->content = nl2br(htmlspecialchars($post_comment->content));
        return $post_comment;
    }

    public function destroy($id)
    {
        $post_comment = PostComment::find($id);
        if (!$post_comment) {
            return response('评论不存在', 404);
        }
        //找到这篇文章的作者的id
        $post_user_id = $post_comment->post->user_id;
        if(\Auth::user()->id != $post_comment->user_id && \Auth::user()->id != $post_user_id){
            return response('权限不足', 403);
        }
        //删除操作
        $res = $post_comment->delete();
        return response('你删除了'.$res.'条评论', 200);
    }
}
