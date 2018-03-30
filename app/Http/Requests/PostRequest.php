<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'content' => 'required|max:500',
            'post_category_id' => 'required|exists:post_categories,id',
        ];

        return $rules;
    }

    /**
     * 重写错误信息
     * @return array
     */

    public function attributes()
    {
        return [
            'post_category_id' => '板块'
        ];
    }
}
