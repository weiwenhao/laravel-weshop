<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name|alpha',
            'display_name' => 'required|unique:roles,display_name',
            'description' => 'nullable|max:20',
            /*'perm_ids.*' => 'required|in_array:1,2,3,4'*/
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = Request::get('id');
            $rules['id'] = 'required';
            $rules['name'] = 'required|alpha|unique:roles,name,'.$id;
            $rules['display_name'] = 'required|unique:roles,display_name,'.$id;
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
            'name.required' => '角色值不能为空。',
            'name.unique' => '角色值已经存在。',
            'display_name.required' => '角色名称必须填写。',
            'display_name.unique' => '角色名称已经存在。',

        ];
    }
}
