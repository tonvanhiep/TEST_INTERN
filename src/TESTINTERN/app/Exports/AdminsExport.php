<?php

namespace App\Exports;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings
{
    public $condition = [];
    public function __construct(Request $request)
    {
        $this->condition = [
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'group' => $request->get('group'),
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
        return ['name', 'email', 'group',];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->condition['name'] == null && $this->condition['email'] == null && $this->condition['group'] == null && $this->condition['is_active'] == null) {
            return AdminModel::select('name', 'email', 'group_role')
                ->where('is_delete', '=' , 0)
                ->orderBy('admin_id', 'desc')
                ->paginate($perPage = 20, $columns = ['*'], $pageName = 'page', $page = 1);
        }
        $group = $this->condition['group'] == null ? -1 : $this->condition['group'];
        $is_active = $this->condition['is_active'] == null ? -1 : $this->condition['is_active'];
        return AdminModel::select('name', 'email', 'group_role')
            ->where('is_delete', '=' , 0)
            ->where('name', 'like', '%'.(($this->condition['name'] == null) ? '' : $this->condition['name']).'%')
            ->where('email', 'like', '%'.(($this->condition['email'] == null) ? '' : $this->condition['email']).'%')
            ->where(function($query) use ($group) {
                $query->where('group_role', '=' ,(($group == -1) ? 1 : $group))
                    ->orWhere('group_role', '=', (($group == -1) ? 2 : $group))
                    ->orWhere('group_role', '=', (($group == -1) ? 3 : $group));
                })
            ->where(function($query) use ($is_active) {
                $query->where('is_active', '=' ,(($is_active == -1) ? 0 : $is_active))
                    ->orWhere('is_active', '=', (($is_active == -1) ? 1 : $is_active));
                })
            ->orderBy('admin_id', 'desc')
            ->get();
    }
}
