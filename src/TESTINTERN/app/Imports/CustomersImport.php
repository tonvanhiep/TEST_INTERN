<?php

namespace App\Imports;
use App\Models\CustomersModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CustomersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $customer = new CustomersModel();

        foreach ($rows as $row)
        {
            if($row == null || $row['name'] == null || $row['email'] == null || $row['tel'] == null) continue;

            $result = $customer->checkExisted($row['email']);
            if(count($result) > 0) continue;

            CustomersModel::create([
                'customer_name' => $row['name'],
                'email' => $row['email'],
                'password' => md5($row['tel']),
                'tel_num' => $row['tel'],
                'address' => ($row['address'] == null) ? '' : $row['address'],
                'is_active' => ($row['active'] == null) ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
