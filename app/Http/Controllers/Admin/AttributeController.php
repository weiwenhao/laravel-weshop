<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
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

    public function ajaxAttributes($type_id){
        $attributes = Attribute::where('type_id', $type_id)->get();
        //属性transform处理
        $attributes->transform(function ($item){
            if($item->option_values){
                $item->option_values = explode(',', $item->option_values);
            }
            return $item;
        });
        return $attributes;
    }

    //修改的主体也应该是类型才对,重点表中的数据应该取出来,但是类型表中的数据也应该取出来, 使用左连接, 从往左往右是type表,attribute表,goods_attribute表
    public function ajaxEditAttr($type_id){ //
        $goods_id = request('goods_id');
        $attributes = DB::table('types') //已类型表取出了该类型下的所有的商品属性id
            ->select('attributes.*',  'goods_attributes.attribute_value', 'goods_attributes.id as goods_attribute_id')
            ->leftJoin('attributes', 'types.id','=','attributes.type_id')
            ->leftJoin('goods_attributes', function ($join) use ($goods_id) {
                $join->on('attributes.id', '=', 'goods_attributes.attribute_id')
                    ->where('goods_attributes.goods_Id', $goods_id); //这里对该类型在商品属性表中数据进行了筛选
            })
            ->where('type_id',$type_id)
            ->get();
        //进行options_values处理
        //属性transform处理
        $attributes->transform(function ($item){
            if($item->option_values){
                $item->option_values = explode(',', $item->option_values);
            }
            return $item;
        });
        return $attributes;
    }
}
