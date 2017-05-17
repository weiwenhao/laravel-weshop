<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
            'content' => 'required', //todo 帖子评论的字数限制
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'exists:users,id',
            'obj_user_id' => 'nullable|exists:users,id',
        ];

        return $rules;
    }
}
