<?php

namespace App\Imports;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\CustomersModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;


class CustomersImport implements ToModel, ShouldQueue, WithChunkReading, WithStartRow, WithHeadingRow
{
    use Importable;

    /**
     * @var errors
     */
    private $errors = [];

    /**
     * @var row
     */
    private $row = 1;

  /**
   * UsersImport constructor.
   * @param StoreEntity $store
   */
    public function __construct($errors = [])
    {
        $this->errors = $errors;
    }

    public function model(array $row)
    {
        if (array_key_exists($this->row++, $this->errors)) {
            return null;
        }
        DB::beginTransaction();
        try {
            CustomersModel::create([
                'customer_name' => $row['name'],
                'email' => $row['email'],
                'password' => md5($row['tel_num']),
                'tel_num' => $row['tel_num'],
                'address' => $row['address'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function startRow(): int
    {
        return 2;
    }
}

