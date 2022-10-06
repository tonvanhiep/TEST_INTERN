<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
            'email' => 'bail|required|unique:MST_ADMIN|min:10|max:255',
            'pass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32',
            're-pass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32|same:pass',
            'group' => 'bail|required||min:1|max:3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute không được bỏ trống.',
            'name.min' => ':attribute phải dài hơn :min ký tự.',
            'name.max' => ':attribute phải không được vượt quá :max ký tự.',

            'email.required' => ':attribute không được bỏ trống.',
            'email.min' => ':attribute phải dài hơn 10 ký tự.',
            'email.max' => ':attribute phải không được vượt quá 255 ký tự.',
            'email.unique' => ':attribute đã tồn tại.',

            'pass.required' => ':attribute không được bỏ trống.',
            'pass.min' => ':attribute phải dài hơn 8 ký tự.',
            'pass.max' => ':attribute phải không được vượt quá 32 ký tự.',

            're-pass.required' => ':attribute không được bỏ trống.',
            're-pass.same' => 'Mật khẩu không khớp.',
        ];
    }
}
