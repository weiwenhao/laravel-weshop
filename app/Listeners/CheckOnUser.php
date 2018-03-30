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
//        dd($event->user->original['sex']);
        /*$event->user; // 同 session('wechat.oauth_user') 一样
        $event->isNewSession*/ // 是不是新的会话（第一次创建 session 时为 true）
        if(env('APP_DEBUG')){
                //第一次进入的时候进行查找判断
                $user = User::where('open_id', $event->user->id)->first();
                if(!$user){
                    $user = User::create([
                        'open_id' => $event->user->id,
                        'username' => $event->user->nickname,
                        'logo' => $event->user->avatar,
                        'sex' => $event->user->original['sex']
                    ]);
                }
                //将该用户设置为已经登陆
                if(!\Auth::check()) { //todo待注释一下
                    \Auth::login($user); //登陆并且记住用户, 仅仅登陆一个用户的有效期是多久
                }
        }else{
            if($event->isNewSession){
                //第一次进入的时候进行查找判断
                $user = User::where('open_id', $event->user->id)->first();
                if(!$user){
                    $user = User::create([
                        'open_id' => $event->user->id,
                        'username' => $event->user->nickname,
                        'logo' => $event->user->avatar,
                        'sex' => $event->user->original['sex']
                    ]);
                }
                //将该用户设置为已经登陆
                \Auth::login($user);
            }
        }

    }
}
