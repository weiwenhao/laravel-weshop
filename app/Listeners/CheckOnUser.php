<?php

namespace App\Listeners;

//use App\Events\Overtrue\LaravelWechat\Events\WeChatUserAuthorized;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Overtrue\LaravelWechat\Events\WeChatUserAuthorized;

class CheckOnUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WeChatUserAuthorized  $event
     * @return void
     */
    public function handle(WeChatUserAuthorized $event)
    {
        /*$event->user; // 同 session('wechat.oauth_user') 一样
        $event->isNewSession*/; // 是不是新的会话（第一次创建 session 时为 true）
        //todo 进行user表维护
        if($event->isNewSession){
            //第一次进入的时候进行查找判断
            $user = User::find($event->user->id);
            if(!$user){
                User::create([
                    'id' => $event->user->id,
                    'nickname' => $event->user->nickname,
                    'avatar' => $event->user->avatar,
                ]);
            }
            //todo 将登陆状态设置为已经登陆, 可以用过 Auth::user() 得到该用户
        }
    }
}
