<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'content' => 'required|min:5|max:255'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'レビュー内容を記入してください',
            'content.min' => ':min 文字以上で記入してください',
            'content.max' => '投稿できる文字数は最大 :max 文字までです'
        ];
    }
}
