<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ValidateAdminFile implements ToCollection, WithStartRow
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
            // dd($rows);

            foreach ($rows as $key => $row) {
                $validator = Validator::make($row->toArray(), [
                    'name' => [
                        'required',
                        'max:255',
                        'min:6',
                    ],
                    'email ' => [
                        'required',
                        'email',
                        'min:10',
                        'max:255',
                        'unique:MST_ADMIN',
                    ],
                    'group_role' => [
                        'required',
                        'min:1',
                        'min:3',
                    ],
                ]);

                if ($validator->fails()) {
                    // $errors[$key] = $validator;
                    dd($validator);
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
