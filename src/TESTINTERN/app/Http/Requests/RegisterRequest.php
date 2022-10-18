<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'bail|required|min:5|max:100',
            'email' => 'bail|required|email|unique:MST_CUSTOMER|min:10|max:255',
            'tel' => 'bail|required|numeric|digits_between:9,15',
            'pass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32',
            're-pass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32|same:pass',
            'agree-rule' => 'bail|required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute は 必要です。',
            'name.min' => ':attribute は :min 文字以上である必要があります。',
            'name.max' => ':attribute  は :max 文字以内である必要があります。',

            'tel.required' => ':attribute は 必要です。',
            'tel.digits_between' => ':attributeは:min桁から:max桁の間で指定してください。',
            'tel.numeric' => ':attributeには、数字を指定してください。',

            'email.required' => ':attribute は 必要です。',
            'email.min' => ':attribute は :min 文字以上である必要があります。',
            'email.max' => ':attribute  は :max 文字以内である必要があります。',
            'email.unique' => ':attributeの値は既に存在しています。',
            'email.email' => ':attributeには、有効なメールアドレスを指定してください。',

            'pass.required' => ':attribute は 必要です。',
            'pass.min' => ':attribute は :min 文字以上である必要があります。',
            'pass.max' => ':attribute  は :max 文字以内である必要があります。',

            're-pass.required' => ':attribute は 必要です。',
            're-pass.same' => '正しくないパスワード。',

            'agree-rule.required' => 'あなたは利用規約に同意する必要があります。',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メール',
            'name' => '名前',
            're-pass' => '再パスワード',
            'pass' => 'パスワード',
            'tel' => '電話番号'
        ];
    }
}
