<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.post_category.list');
    }

    public function dtData()
    {
        return Datatables::of(PostCategory::query())->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategoryRequest $request)
    {
        //得到保存路径
        $post_category = PostCategory::create($request->all());
        if(!$post_category)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect('/admin/post_categories/create')->withInput()->with('error', '系统错误，添加失败');
        return redirect('/admin/post_categories')->withSuccess('添加成功');
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
        $post_category = PostCategory::findOrFail($id);
        return view('admin.post_category.edit', compact('post_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostCategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategoryRequest $request, $id)
    {
        $post_category = PostCategory::findOrFail($id);
        $res = $post_category->update($request->all());
        if(!$res )
           return redirect('/admin/post_categories/edit/'.$id)->withInput()->with('error', '系统错误，修改失败');
        return redirect('/admin/post_categories')->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_category = PostCategory::find($id);
        if (!$post_category)
            return response('删除失败',403);
        $res = $post_category->delete(); //成功返回删除的记录条数
        return (string) $res;
    }
}
