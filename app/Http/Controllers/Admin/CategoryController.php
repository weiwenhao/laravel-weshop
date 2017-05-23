<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.category.list');
    }

    public function dtData()
    {
        return Datatables::of(Category::query())->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, Category $category)
    {
        //保存logo
        $data = $request->all();
        if($logo = $request->hasFile('logo'))
            $data = array_merge($data, $category->saveCategoryLogo());
        $category = Category::create($data);
        if(!$category)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect('/admin/categories/create')->withInput()->with('error', '系统错误，添加失败');
        return redirect('/admin/categories')->withSuccess('添加成功');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->all();
        //保存logo
        if($logo = $request->hasFile('logo')){
            $category->removeCategoryLogo();
            $data = array_merge($data, $category->saveCategoryLogo());
        }

        $res = $category->update($data);
        if(!$res )
           return redirect('/admin/categories/edit/'.$id)->withInput()->with('error', '系统错误，修改失败');
        return redirect('/admin/categories')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        //如果该分类下存在商品则不允许删除
        $goods_count = Goods::where('category_id', $category->id)->count();
        if($goods_count > 0)
            return response('该分类下存在商品,不允许删除', 403);
        if (!$category)
            return response('资源不存在', 404);
        $res = $category->delete();
        if($res)
            $category->removeCategoryLogo();

        return (string) $res;
    }
}
