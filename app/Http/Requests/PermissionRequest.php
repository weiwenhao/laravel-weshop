<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PermissionRequest extends FormRequest
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
            'name' => 'sometimes|required|unique:permissions,display_name',
            'display_name'=>'required|unique:permissions,display_name',
            'sort' => 'sometimes|integer',
            'parent_id' => 'integer',
            'description' => 'sometimes|nullable|max:20'
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = Request::get('id');
            $rules['name'] = 'sometimes|required|unique:permissions,display_name,'.$id;
            $rules['id'] = 'sometimes|required';
            $rules['display_name'] = 'required|unique:permissions,display_name,'.$id;
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
            'name.required' => '权限值不能为空。',
            'name.unique' => '权限值已经存在。',
            'display_name.required' => '权限名称必须填写。',
            'display_name.unique' => '权限名称已经存在。',
            'sort.integer' => '权重必须为整数。'

        ];
    }
}
