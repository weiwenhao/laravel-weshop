<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoodsRequest;
use App\Models\Category;
use App\Models\Goods;
use App\Models\Number;
use App\Models\ShopCart;
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
        return Datatables::of(
            Goods::with('category')
            ->select('goods.id', 'goods.name', 'goods.price', 'goods.sort',
                'goods.is_sale', 'goods.is_best', 'goods.buy_count', 'goods.sm_image', 'goods.created_at', 'category_id')
            ->where('is_deleted', 0)
        )->make(true);
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
        $data = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'sort' => $request->get('sort'),
            'description' => $request->get('description'),
            'promote_price' => (float)$request->get('promote_price'),
            'promote_start_at' => $request->get('promote_start_at'),
            'promote_stop_at' => $request->get('promote_stop_at'),
            'is_best' => $request->get('is_best'),
            'is_sale' => $request->get('is_sale'),
            'is_best' => $request->get('is_best'),
            'type_id' => (int)$request->get('type_id'),
            'category_id' => (int)$request->get('category_id'),
        ];
        //得到保存路径
        $data = array_merge($data, $goods->saveGoodsImage());
        $goods = Goods::create($data);
        if(!$goods)//withInput代表的是用户原先的输入,会操作old中的值
            return redirect('/admin/goods/create')->withInput()->with('error', '系统错误，添加失败');
        //商品属性保存到中间表
        $goods_attr_ids = $goods->saveGoodsAttr($goods->id);
        //创建相应的库存数据
        $number = new Number();
        $number->createNumbers($goods);

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
        $data = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'sort' => $request->get('sort'),
            'description' => (string)$request->get('description'),
            'promote_price' => (float)$request->get('promote_price'),
            'promote_start_at' => $request->get('promote_start_at'),
            'promote_stop_at' => $request->get('promote_stop_at'),
            'is_best' => $request->get('is_best'),
            'is_sale' => $request->get('is_sale'),
            'is_best' => $request->get('is_best'),
            'type_id' => (int)$request->get('type_id'),
            'category_id' => (int)$request->get('category_id'),
        ];;
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
        $goods->editGoodsAttr($id);
        //库存量修改
        $number = new Number();
        $number->editNumbers($goods);

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
            return response('删除失败，商品不存在',403);
//        $goods->removeGoodsImage();
        $goods->is_deleted = 1;
        $goods->save();
        return response('删除成功', 200);
    }

    public function delGoodsAttr($goods_attribute_id){
        $res = DB::table('goods_attributes')->where('id', $goods_attribute_id)->delete();
        //情况1   29,129,30 在开头 情况2 129,29,30 情况三 129,30,29 情况4 29
        $regex = "^$goods_attribute_id,|,$goods_attribute_id,|,$goods_attribute_id$|^$goods_attribute_id$";
        //删除属性的后进行库存表含有该数据的属性的删除删除
        Number::where('goods_attribute_ids', 'regexp', $regex)->delete();
        // 删除属性的后进行购物车表含有该数据的属性的删除删除
        ShopCart::where('goods_attribute_ids', 'regexp', $regex)->delete();
        return $res;
    }

    public function updateIsSale(Request $request)
    {
        $is_sale = $request->get('is_sale');
        $goods_ids = $request->get('goods_ids');
        $count = Goods::whereIn('id', $goods_ids)->update([
           'is_sale' => $is_sale
        ]);
        return $count;
    }
}
