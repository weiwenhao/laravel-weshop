<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class AdminRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $rules['id'] = 'required';
            $rules['email'] = 'required|email|max:255|unique:admins,email,'.Request::get('id');
            $rules['password'] = 'nullable|min:6|confirmed'; //nullable 代表字段为空时满足条件,否则进行后续的验证
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
            'name.required' => '用户名不能为空。',
        ];
    }
}
