<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class NumberRequest extends FormRequest
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
            'price.*' => ['nullable', 'regex:/^\d{1,6}\.\d{1,2}$|^\d{1,6}$/'],
            'number.*' => 'required|integer',
        ];
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

   /* public function attributes()
    {
        return [
          'price.*' => '商品价格'
        ];
    }*/
}
