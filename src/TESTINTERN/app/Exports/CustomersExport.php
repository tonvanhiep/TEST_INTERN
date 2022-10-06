<?php

namespace App\Exports;

use App\Models\CustomersModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["id", "name", "email", "tel", "address", "active", "created_at", "updated_at"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomersModel::select('customer_id','customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at', 'updated_at')->get();
    }
}
