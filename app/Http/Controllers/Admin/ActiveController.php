<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActiveRequest;
use App\Models\Active;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class ActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.active.list');
    }

    public function dtData()
    {
        return Datatables::of(Active::select('id','name', 'image', 'sort', 'is_show', 'is_content', 'created_at'))
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.active.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ActiveRequest $request
     * @param Active $active
     * @return \Illuminate\Http\Response
     */
    public function store(ActiveRequest $request, Active $active)
    {
        //图片处理
        $data = array_merge($request->all(), $active->saveActiveImage());
        $active = Active::create($data);
        if(!$active)//withInput代表的是用户原先的输入,会操作old中的值 //todo 如何填充到error中错误呢??
            return redirect('/admin/actives/create')->withInput()->with('error', '系统错误，添加失败');
        return redirect('/admin/actives')->withSuccess('添加成功');
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
        $active = Active::findOrFail($id);
        return view('admin.active.edit', compact('active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ActiveRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActiveRequest $request, $id)
    {
        $active = Active::findOrFail($id);
        $data = $request->all();
        //判断用户是否选择了图片
        if ($request->hasFile('image')){
            $data = array_merge($data, $active->saveActiveImage());
            //进行原来图片的删除处理
            $active->removeActiveImage();
        }
        $res = $active->update($data);
       if(!$res )
           return redirect('/admin/actives/edit/'.$id)->withInput()->with('error', '系统错误，修改失败');
        return redirect('/admin/actives')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $active = Active::find($id);
        if (!$active)
            return response('资源不存在',403);
        $res = $active->delete(); //成功返回1?失败返回0?
        if($res){
            //删除图片
            $active->removeActiveImage();
        }
        return (string) $res;
    }
}
