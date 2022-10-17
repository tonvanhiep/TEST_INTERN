<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvFileRequest extends FormRequest
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
            'filecsv' => 'required|file|size:20|mimes:csv,txt'
        ];
    }

    public function messages()
    {
        return [
            'filecsv.required' => ':attribute は 必要です。',
            'filecsv.file' => ':attributeにはファイルを指定してください。',
            'filecsv.mimes' => ':attributeには:valuesタイプのファイルを指定してください。',
            'filecsv.size' => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。'
        ];
    }

}
