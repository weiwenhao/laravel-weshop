<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
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
            //在当前type_id下的唯一性
            'name' => ['required', 'max:10', Rule::unique('attributes')->where(function ($query) {
                $query->where('type_id', request('type_id')); //仅仅在type_id为制定的情况下进行判断唯一
            })],

            'type' => ['required', Rule::in(['唯一', '可选'])] //通常可以用作复选框,或者单选框
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = Request::get('id');
            $rules['name'] = ['required', 'max:10', Rule::unique('attributes')->where(function ($query) {
                $query->where('type_id', request('type_id'));
            })->ignore($id)];
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

    public function attributes()
    {
        return [
            'name' => '属性名称',
            'type' => '属性类型'
        ];
    }
}
