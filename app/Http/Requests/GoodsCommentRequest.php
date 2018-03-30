<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsCommentRequest extends FormRequest
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
        $rules = [
            'content' => 'required|max:1024',
            'level' => 'required|integer|between:1,5',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'level' => '评分',
            'content' => '评价内容',
        ];
    }
}
