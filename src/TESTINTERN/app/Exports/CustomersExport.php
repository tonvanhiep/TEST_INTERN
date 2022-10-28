<?php

namespace App\Exports;

use App\Models\CustomersModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public $condition = [];
    public function __construct(Request $request)
    {
        $this->condition = [
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'is_active' => $request->get('is_active')
        ];
    }
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
        return ["name", "email","tel_num", "address"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->condition['name'] == null && $this->condition['email'] == null && $this->condition['address'] == null && $this->condition['is_active'] == null) {
            return CustomersModel::select('customer_name', 'email', 'tel_num', 'address')
                ->orderBy('customer_id', 'desc')
                ->paginate($perPage = 20, $columns = ['*'], $pageName = 'page', $page = 1);
        }

        $is_active = $this->condition['is_active'] == null ? -1 : $this->condition['is_active'];
        return CustomersModel::select('customer_name', 'email', 'tel_num', 'address')
                ->where('customer_name', 'like', '%'.(($this->condition['name'] == null) ? '' : $this->condition['name']).'%')
                ->where('email', 'like', '%'.(($this->condition['email'] == null) ? '' : $this->condition['email']).'%')
                ->where('address', 'like', '%'.(($this->condition['address'] == null) ? '' : $this->condition['address']).'%')
                ->where(function($query) use ($is_active) {
                    $query->where('is_active', '=' ,(($is_active == -1) ? 0 : $is_active))
                        ->orWhere('is_active', '=', (($is_active == -1) ? 1 : $is_active));
                    })
                ->orderBy('customer_id', 'desc')
            ->get();
    }
}
