<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ValidateAdminFile implements ToCollection, WithStartRow, WithHeadingRow
{
  /**
     * @var errors
     */
    public $errors = [];

    /**
     * @var isValidFile
     */
    public $isValidFile = false;

    /**
     * ValidateAdminFile constructor.
     * @param StoreEntity $store
     */
    public function __construct()
    {
        //
    }

    public function collection(Collection $rows)
    {
        $errors = [];
        if (count($rows) > 1) {
            $rows = $rows->slice(1);

            foreach ($rows as $key => $row) {
                $validator = Validator::make($row->toArray(), [
                    'name' => [
                        'required',
                        'max:255',
                        'min:6',
                    ],
                    'email' => [
                        'required',
                        'email',
                        'min:10',
                        'max:255',
                        Rule::unique('MST_ADMIN', 'email'),
                    ],
                    'group' => [
                        'required',
                        'numeric',
                        'min:1',
                        'max:3',
                    ],
                ], [
                    'min' => ':attribute は :min 文字以上である必要があります。',
                    'max' => ':attribute  は :max 文字以内である必要があります。',
                    'unique' => ':attributeの値は既に存在しています。',
                    'required' => ':attribute は 必要です。',
                    'email' => ':attributeには、有効なメールアドレスを指定してください。',
                    'numeric' => ':attributeには、数字を指定してください。',
                ]);

                if ($validator->fails()) {
                    $errors[$key] = $validator->getMessageBag()->getMessages();
                }
            }
            $this->errors = $errors;
            $this->isValidFile = true;
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}
