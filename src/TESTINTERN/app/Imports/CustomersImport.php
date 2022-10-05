<?php

// namespace App\Imports;

// use App\Models\CustomersModel;
// use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Concerns\ToModel;

// class CustomersImport implements ToModel
// {
//     /**
//      * @param array $row
//      *
//      * @return CustomersModel|null
//      */
//     public function model(array $row)
//     {
//         dd($row);
//         return new CustomersModel([
//            'customer_name'     => $row[0],
//            'email'    => $row[1],
//            'tel_num' => $row[2],
//            'pass' => $row[2],
//            'is_active' => 1,
//         ]);
//     }
// }
namespace App\Imports;
use App\Models\CustomersModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            // CustomersModel::create([
            //     'name' => $row[0],
            // ]);
            var_dump($row);
        }
    }
}
