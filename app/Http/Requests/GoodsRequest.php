<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class GoodsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
//            'category_id' => 'required|exists:category,id',
            'category_id' => 'required',
            'name' => 'required|between:2,30',
            'price' => ['required', 'regex:/^\d{1,6}\.\d{1,2}$|^\d{1,6}$/'],
            'promote_price' => ['nullable', 'regex:/^\d{1,6}\.\d{1,2}$|^\d{1,6}$/'], //小数点后面两位
            'promote_start_at' => 'nullable|date_format:Y-m-d H:i:s',
            'promote_stop_at' => 'nullable|date_format:Y-m-d H:i:s',
            'sort' => 'required|integer',
            'is_sale' => 'required|boolean',
            'is_best' => 'required|boolean',
            'image' => 'required|image'
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
//            $id = Request::get('id');
            $rules['image'] = 'nullable|image';
        }
        return $rules;
    }

    /**
     * 重写错误信息
     * @return array
     */
    public function messages()
    {
        return [
            'price' => ':attribute 格式错误。',
            'promote_price.regex' => ':attribute 格式错误。'
        ];
    }

    /**
     * 重写属性名称
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '商品名称',
            'sort' => '权重',
            'price' => '商品价格',
            'promote_price' => '促销价格',
            'promote_start_at' => '促销开始时间',
            'promote_stop_at' => '促销开始时间',
            'image' => '商品图片',
            'category_id' => '商品分类'

        ];
    }
}
