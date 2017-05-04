<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class ActiveRequest extends FormRequest
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
            'name' => 'required|max:10|unique:actives,name',
            'url' => 'required|max:10|unique:actives,url',
            'sort' => 'required|integer',
            'is_show' => 'required|boolean',
            'is_content' => 'required|boolean',
            'image' => 'required|image'
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = Request::get('id');
            $rules['name'] = 'required|max:10|unique:actives,name,'.$id;
            $rules['url'] = 'required|max:10|unique:actives,url,'.$id;
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

        ];
    }

    /**
     * 重写属性名称
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '活动名称',
            'sort' => '权重',
            'image' => '活动封面',
            'url' => '英文名称',
        ];
    }
}
