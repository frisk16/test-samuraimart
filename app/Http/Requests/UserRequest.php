<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|min:3|max:20',
            'email' => 'required|unique:users,email,' . $this->user()->id . ',id',
            'postal_code' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.min' => '最低 :min 文字以上で登録してください',
            'name.max' => ':max 文字以内で登録してください',
            'email.required' => 'Eメールアドレスを入力してください',
            'email.unique' => 'そのEメールアドレスは既に使用されています',
            'postal_code.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
            'phone.required' => '電話番号を入力してください'
        ];
    }
}
