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
        return ["名前", "メール","電話番号", "住所"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomersModel::select('customer_name', 'email', 'tel_num', 'address')->get();
    }
}
