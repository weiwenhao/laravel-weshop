<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostImage;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Application $wechat
     * @return \Illuminate\Http\Response
     */
    public function index(Application $wechat)
    {
        //jssdk
        $js = $wechat->js;
        return view('circle.list', compact('js'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('circle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post_category_id = $request->get('post_category_id');
        $content = $request->get('content');
        $post = Post::create([
            'user_id' => \Auth::user()->id,
            'post_category_id' => $post_category_id,
            'content' => $content
        ]);
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * 存储文章图片
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $post_id = $request->get('post_id');
        //图片存储
        $path = config('shop.circle_img_path').date('Ymd').'/';
        $circle_img_name =  md5(time().str_random(4)).'.jpg'; //当前时间精确到秒+4位随机数的MD5加密
        if(!is_dir(public_path($path))){
            mkdir(public_path($path), 0777, true); //第三个参数代表递归创建
        }
        //or @mkdir(public_path($path), 0777, true);
        //这里裁剪,再充值尺寸

        //进行图片的存储测试
        \Image::make($request->file('post_img'))
            ->resize(600, null, function ($constraint) { //将图片的尺寸固定在了600
                $constraint->aspectRatio();
            })->save($path.$circle_img_name);
        \Image::make($request->file('post_img'))->fit($size = config('shop.sm_circle_img_size'), $size)->save($path.'sm_'.$circle_img_name);
        $post_img = PostImage::create([
            'post_id' => $post_id,
            'image' =>   '/'.$path.$circle_img_name,
            'sm_image' => '/'.$path.'sm_'.$circle_img_name,
        ]);
        return $post_img;
    }

    /**
     * 得到帖子分类数据
     * @return \Illuminate\Support\Collection
     */
    public function ajaxCategories()
    {
        $categories = \DB::table('post_categories')->get();
        return $categories;
    }

    /**
     * 得到帖子列表
     * @param Request $request
     * @param Post $post
     * @return
     */
    public function ajaxPosts(Request $request, Post $post)
    {
        $posts = $post->getPosts($request);
        return $posts;
    }

    /**
     * ajax删除帖子
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function ajaxDestroy($id)
    {
        $post = Post::find($id);
        if(!$post){
            return response('帖子不存在', 404);
        }
        if(\Auth::user()->id != $post->user_id){
            return response('权限不足', 403);
        }
        $res = $post->delete();
        //删除图片
        $post->delImage($post->id);
        return response('你成功删除了'.$res.'条帖子', 200);
    }
}
