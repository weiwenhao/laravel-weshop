<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Yajra\Datatables\Facades\Datatables;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $type_id
     * @return \Illuminate\Http\Response
     */
    public function index($type_id)
    {
        $type = Type::findOrFail($type_id);
        return view('admin.attribute.list', compact('type'));
    }

    public function dtData($type_id)
    {
        $query = Type::findOrFail($type_id)->attributes();
        return Datatables::of($query)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $type_id
     * @return \Illuminate\Http\Response
     */
    public function create($type_id)
    {
        $type = Type::findOrFail($type_id);
        return view('admin.attribute.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeRequest $request
     * @param $type_id
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request, $type_id)
    {
//        dd('通过');
        //得到保存路径
        $model = Attribute::create(array_merge($request->all(),['type_id' => $type_id]));
        if(!$model)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect()->route('attributes.create',[$type_id])->withInput()->with('error', '系统错误，添加失败');
        return redirect()->route('attributes.index',[$type_id])->withSuccess('添加成功');
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
     * @param $type_id
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($type_id, $id)
    {
        $type = Type::findOrFail($type_id);
        $attribute = Attribute::findOrFail($id);
        return view('admin.attribute.edit', compact('type', 'attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeRequest $request
     * @param $type_id
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $type_id, $id)
    {
        $model = Attribute::findOrFail($id);
        $res = $model->update($request->all());
       if(!$res )
           return redirect()->route('attributes.update', [$type_id, $id])->withInput()->with('error', '系统错误，修改失败');
        return redirect()->route('attributes.index', [$type_id])->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type_id, $id)
    {
        $model = Attribute::find($id);
        if (!$model)
            return response('删除失败',403);
        $res = $model->delete(); //成功返回1?失败返回0?
        return (string) $res;
    }
}
