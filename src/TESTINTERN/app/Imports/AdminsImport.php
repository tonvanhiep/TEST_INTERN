<?php

namespace App\Imports;

use App\Models\AdminModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $admin = new AdminModel();

        foreach ($rows as $row)
        {
            if($row == null || $row['name'] == null || $row['email'] == null || $row['group'] == null) continue;

            $result = $admin->checkExisted($row['email']);
            if(count($result) > 0) continue;

            AdminModel::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => md5(123456789),
                'is_active' => ($row['active'] == null) ? 0 : 1,
                'group_role' => $row['group'],
                'is_delete' => ($row['delete'] == null) ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
