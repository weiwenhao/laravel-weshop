<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddrRequest;
use App\Models\Addr;
use Illuminate\Http\Request;

class AddrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(\request());
        $addrs = Addr::where('user_id', \Auth::user()->id)->get();
        return view('addr.list', compact('addrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddrRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddrRequest $request)
    {
        if($request->get('is_default') == 1){
            //将该用户的其他地址的is_default 设置为0
            Addr::where('user_id', \Auth::user()->id)->where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }
        //数据入库
        $res = Addr::create(
            array_merge(
                $request->only(['name', 'phone', 'floor_name', 'number', 'is_default']),
                ['user_id'=>\Auth::user()->id]
            )
        );

        if($res){
            return response('添加成功', 200);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addr = Addr::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();
        return view('addr.edit', compact('addr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddrRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddrRequest $request, $id)
    {
        //总之先查找一条数据
        $addr = Addr::where('id', $id)->where('user_id', \Auth::user()->id)->firstOrFail();

        if($request->get('is_default') == 1){
            Addr::where('user_id', \Auth::user()->id)->where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }
        //数据修改
        $res = $addr->update($request->only(['name', 'phone', 'floor_name', 'number', 'is_default']));
        if($res){
            return response('修改成功', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addr = Addr::where('user_id', \Auth::user()->id)->where('id', $id)->first();
        if(!$addr){
            return response('系统错误，请联系客服！', 403); //403既无权删除的意思
        }
        $res = $addr->delete(); //返回删除的记录数
        return response('删除成功', 200);
    }
}
