<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddrRequest extends FormRequest
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
        //一级权限, 有图标,无url
        //二级权限, 无图标,有url
        //三级权限, 无图标,无url
        $rules =  [
            'name' => 'required|between:2,5',
            'phone' => ['required', 'regex:/^(13|14|15|18|17)[0-9]{9}$/'],
            'floor_name' => 'required|between:3,3', //待验证准确性
            'number' => 'required|digits:3',
            'is_default' => 'required|boolean'
        ];
        /*if (Request::isMethod('PATCH') || Request::isMethod('PUT')){

        }*/
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

    public function attributes()
    {
        return [
            'name' => '姓名',
            'phone' => '手机号码',
            'floor_name' => '地址',
            'number' => '门牌号',
            'is_default' => '默认地址'
        ];
    }
}
