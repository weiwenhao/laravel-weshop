<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeController extends Controller
{
    public function index()
    {
        //session记录一下当前url方便存储 todo 待重构为cookie,或者中间件
        session(['addrs_previous_url' => \request()->getUri()]);
        \Cookie::queue('orders_previous_url', \request()->getUri());

        return view('me.index');
    }
}
