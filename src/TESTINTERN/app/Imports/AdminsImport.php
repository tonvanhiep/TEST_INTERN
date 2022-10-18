<?php
namespace App\Imports;

use App\Models\AdminModel;
use Exception;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class AdminsImport implements ToCollection, WithHeadingRow
// {
//     public function collection(Collection $rows)
//     {
//         $admin = new AdminModel();

//         foreach ($rows as $row)
//         {
//             if($row == null || $row['name'] == null || $row['email'] == null || $row['group'] == null) continue;

//             $result = $admin->checkExisted($row['email']);
//             if(count($result) > 0) continue;

//             AdminModel::create([
//                 'name' => $row['name'],
//                 'email' => $row['email'],
//                 'password' => md5(123456789),
//                 'is_active' => 1,
//                 'group_role' => $row['group'],
//                 'is_delete' => 0,
//                 'created_at' => date('Y-m-d H:i:s'),
//                 'updated_at' => date('Y-m-d H:i:s')
//             ]);
//         }
//     }
// }

class AdminsImport implements ToModel, ShouldQueue, WithChunkReading, WithStartRow, WithHeadingRow
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
            AdminModel::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => md5(123456789),
                'is_active' => 1,
                'group_role' => $row['group'],
                'is_delete' => 0,
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
