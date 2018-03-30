<?php

namespace App\Http\Controllers;

use App\Models\PostNews;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class PostNewsController extends Controller
{
    /**
     * @param Application $wechat
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Application $wechat)
    {
        //jssdk
        $js = $wechat->js;
        return view('post.news', compact('js'));
    }

    public function ajaxPostNews(Request $request, PostNews $post_news)
    {
        $post_news = $post_news->getPostNews($request);
        //设为已经读取
        PostNews::where('obj_user_id', \Auth::user()->id)->whereNull('read_at')->update([
            'read_at' => date('Y-m-d H:i:s')
        ]);
        return $post_news;
    }
}
