<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'bail|required|email|min:10|max:255',
            'pass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute は 必要です。',
            'email.email' => ':attributeは有効な電子メール アドレスである必要があります。',
            'email.min' => ':attributeは :min 文字以上である必要があります。',
            'email.max' => ':attributeは :max 文字以内である必要があります。',

            'pass.required' => ':attribute は 必要です。',
            'pass.min' => ':attribute は :min 文字以上である必要があります。',
            'pass.max' => ':attribute は :max 文字以内である必要があります。',
            'pass.regex' => ':attribute は 形式が無効です。'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メール',
            'name' => '名前',
            're-pass' => '再パスワード',
            'pass' => 'パスワード',
        ];
    }
}
