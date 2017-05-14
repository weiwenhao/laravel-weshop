<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\NumberRequest;
use App\Models\Goods;
use App\Models\Number;
use App\Http\Controllers\Controller;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($goods_id)
    {
        /**
         * 数据分析
         * 46,48,49
         * 白色,土豪金,2G
         * 上面三个所属于的goods_attribute_id一定是不同的
         */
        $numbers = Number::where('goods_id', $goods_id)->get();
        //可选属性值
        $goods_attrs = \DB::table('goods_attributes')->select('goods_attributes.id as goods_attr_id', 'goods_attributes.attribute_value', 'attributes.name')
            ->join('attributes', function ($join){
                $join->on('goods_attributes.attribute_id', '=', 'attributes.id');
            })
            ->where('goods_attributes.goods_id', $goods_id)
            ->where('attributes.type', '可选')
            ->orderBy('goods_attributes.id', 'asc')
            ->get();
        $goods_attrs = $goods_attrs->groupBy('name');
        $goods = Goods::select('name', 'id')->findOrFail($goods_id);
        return view('admin.number.list', compact('numbers', 'goods_attrs', 'goods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NumberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NumberRequest $request, $goods_id)
    {
        $numbers = $request->get('number');
        $prices = $request->get('price');
        foreach ($numbers as $id=>$number){
            Number::where('id', $id)->where('goods_id', $goods_id)->update([
                'number' => $number,
                'price' => $prices[$id]
            ]);
        }
        return redirect()->route('numbers.index', ['goods_id'=> $goods_id])->withSuccess('更新成功');
    }

}
