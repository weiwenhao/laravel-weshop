<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoodsRequest;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.goods.list');
    }

    public function dtData()
    {
        return Datatables::of(Goods::with('category'))->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(['id','name']);
        return view('admin.goods.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GoodsRequest $request
     * @param Goods $goods
     * @return \Illuminate\Http\Response
     */
    public function store(GoodsRequest $request, Goods $goods)
    {
        //得到保存路径
        $data = array_merge($request->all(), $goods->saveGoodsImage());
        $goods = Goods::create($data);
        if(!$goods)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect('/admin/goods/create')->withInput()->with('error', '系统错误，添加失败');
        //商品属性保存到中间表
        $goods->saveGoodsAttr($goods->id);
        return redirect('/admin/goods')->withSuccess('添加成功');
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
        $goods = Goods::findOrFail($id);
        $categories = Category::all(['id','name']);
        return view('admin.goods.edit', compact('goods', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GoodsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodsRequest $request, $id)
    {
        $goods = Goods::findOrFail($id);
        $data = $request->all();
        //判断用户是否选择了图片
        if ($request->hasFile('image')){
           $data = array_merge($data, $goods->saveGoodsImage());
           //进行原来图片的删除处理
           $goods->removeGoodsImage();
        }
        //入库操作
        $res = $goods->update($data);
        if (!$res )
           return redirect('/admin/goods/edit/'.$id)->withInput()->with('error', '系统错误，修改失败');
        //商品属性修改
        //商品属性修改
        $goods->editGoodsAttr($id);
        return redirect('/admin/goods')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goods = Goods::find($id);
        if (!$goods)
            return response('删除失败',403);
        $goods->removeGoodsImage();
        $res = $goods->delete();
        return (string) $res;
    }

    public function delGoodsAttr($goods_attribute_id){
        $res = DB::table('goods_attributes')->where('id', $goods_attribute_id)->delete();
        //todo 库存删除
        return $res;
    }
}
