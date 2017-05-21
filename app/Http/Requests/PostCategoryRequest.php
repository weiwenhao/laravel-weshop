<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PostCategoryRequest extends FormRequest
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
            'name' => 'required|max:10|unique:post_categories,name',
            'sort' => 'required|integer',
        ];
        if (Request::isMethod('PATCH') || Request::isMethod('PUT')){
            $id = $this->route('post_category');
            $rules['name'] = 'required|max:10|unique:post_categories,name,'.$id;
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
            'name' => '板块名称',
            'sort' => '权重'
        ];
    }
}
