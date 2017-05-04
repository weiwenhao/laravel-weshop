<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $post_id
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $post = Post::find($post_id);
        return view('admin.post_comment.list', compact('post'));
    }

    public function dtData($post_id)
    {
        return Datatables::of(PostComment::where('post_id', $post_id))->make(true);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id ,$id)
    {
        $post_comments = PostComment::find($id);
        if (!$post_comments)
            return response('删除失败',403);
        $res = $post_comments->delete(); //成功返回1?失败返回0?
        return (string) $res;
    }
}
