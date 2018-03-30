<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CategoryRequest extends FormRequest
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
            'name' => 'required|max:10|unique:categories,name',
            'sort' => 'required|integer',
            'is_show' => 'required|boolean',
            'logo' => 'required|image'
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = Request::route('category');
            $rules['name'] = 'required|max:10|unique:categories,name,'.$id;
            $rules['logo'] = 'nullable|image';
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
            'name' => '分类名称',
            'logo' => '封面',
        ];
    }
}
