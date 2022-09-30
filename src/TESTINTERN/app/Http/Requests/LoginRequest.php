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
            'email.required' => ':attribute không được bỏ trống.',
            'email.email' => ':attribute không phải là địa chỉ email.',
            'email.min' => ':attribute  phải dài hơn 10 ký tự.',
            'email.max' => ':attribute  phải không được vượt quá 255 ký tự.',

            'pass.required' => ':attribute không được bỏ trống.',
            'pass.min' => ':attribute  phải dài hơn 8 ký tự.',
            'pass.max' => ':attribute  phải không được vượt quá 32 ký tự.',
            'pass.regex' => ':attribute chỉ bao gồm chữ cái viết hoa, viết thường và chữ số.'
        ];
    }
}
