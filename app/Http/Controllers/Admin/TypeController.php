<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TypeRequest;
use App\Models\Attribute;
use App\Models\Type;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.type.list');
    }

    public function dtData()
    {
        return Datatables::of(Type::query())->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {
        //得到保存路径
        $model = Type::create($request->all());
        if(!$model)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect('/admin/types/create')->withInput()->with('error', '系统错误，添加失败');
        return redirect('/admin/types')->withSuccess('添加成功');
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
        $type = Type::findOrFail($id);
        return view('admin.type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TypeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeRequest $request, $id)
    {
        $model = Type::findOrFail($id);
        $res = $model->update($request->all());
       if(!$res )
           return redirect('/admin/types/edit/'.$id)->withInput()->with('error', '系统错误，修改失败');
        return redirect('/admin/types')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Type::find($id);
        //删除该类型对应的属性
        Attribute::where('type_id', $id)->delete();
        if (!$model)
            return response('删除失败',403);
        $res = $model->delete(); //成功返回1?失败返回0?
        return (string) $res;
    }
}
