<?php

namespace App\Exports;

use App\Models\AdminModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings
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
        return ["id", "name", "email", "active", "delete", "group", "created_at", "updated_at"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AdminModel::select('admin_id','name', 'email', 'is_active', 'is_delete', 'group_role', 'created_at', 'updated_at')->get();
    }
}
