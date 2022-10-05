<?php

namespace App\Exports;

use App\Models\CustomersModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomersExport implements FromCollection
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
        return ["ID", "Name", "Email", "Telephone", "Address", "Active", "Created At", "Updated at"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomersModel::select('customer_id','customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at', 'updated_at')->get();
    }
}
