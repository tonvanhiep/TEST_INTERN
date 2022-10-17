<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportCsvFileRequest;
use App\Imports\AdminsImport;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminManagementController extends Controller
{
    private $admin;
    public $adminOnPage = 20;

    public function __construct()
    {
        $this->admin = new AdminModel();
    }

    public function index(Request $request)
    {
        $nameRoute = $request->route()->getName();
        $page = (!$request->has('page') ? 1 : $request->page);
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'group' => (!$request->has('group') ? -1 : $request->group),
            'email' => (!$request->has('email') ? null : $request->email)
        );
        $totalAdmin = $this->admin->getCountAdmin($condition);
        $totalPage = intval($totalAdmin / $this->adminOnPage + (($totalAdmin % $this->adminOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->adminOnPage + 1,
            'max' => ($currentPage * $this->adminOnPage <= $totalAdmin) ? ($currentPage * $this->adminOnPage) : $totalAdmin,
            'total' => $totalAdmin
        ];
        $listAdmin = $this->admin->getAdmin($condition, $currentPage, $this->adminOnPage);
        return view('admin.admin-management', compact('listAdmin', 'record', 'totalPage', 'currentPage', 'nameRoute'));
        return 'index';
    }

    public function paginationAdmin(Request $request)
    {
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'group' => (!$request->has('group') ? -1 : $request->group),
            'email' => (!$request->has('email') ? null : $request->email)
        );

        $page = ($request->page >= 1) ? $request->page : 1;
        $totalAdmin = $this->admin->getCountAdmin($condition);
        $totalPage = intval($totalAdmin / $this->adminOnPage + (($totalAdmin % $this->adminOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->adminOnPage + 1,
            'max' => ($currentPage * $this->adminOnPage <= $totalAdmin) ? ($currentPage * $this->adminOnPage) : $totalAdmin,
            'total' => $totalAdmin
        ];
        $listAdmin = $this->admin->getAdmin($condition, $currentPage, $this->adminOnPage);

        $returnHTML = view('admin.pagination-admin-management', compact('listAdmin', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
    }

    public function editAdmin(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0',
            'name' => 'required',
            'group' => 'required|min:1|max:3',
            'email' => 'required|email',
            'is_active' => 'required|min:0|max:1'
            ]
        );

        $id = $request->id;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'group' => $request->group,
            'is_active' => $request->is_active
            ];
        $result = $this->admin->updateAdmin($id, $data);

        if($result['success'] == false) {
            return response()->json([
                'message' => $result['message'],
                'errors' => [
                    'email' => [$result['message']]
                ]
            ], 422);
        }
        return 'Success';

        // return 'editAdmin';
    }

    public function deleteAdmin(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0'
            ]
        );
        $this->admin->deleteAdmin($request->id);

        return 'Success';
    }

    public function searchAdmin(Request $request)
    {
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'group' => (!$request->has('group') ? -1 : $request->group),
            'email' => (!$request->has('email') ? null : $request->email)
        );
        $page = ($request->page >= 1) ? $request->page : 1;
        $totalAdmin = $this->admin->getCountAdmin($condition);
        $totalPage = intval($totalAdmin / $this->adminOnPage + (($totalAdmin % $this->adminOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->adminOnPage + 1,
            'max' => ($currentPage * $this->adminOnPage <= $totalAdmin) ? ($currentPage * $this->adminOnPage) : $totalAdmin,
            'total' => $totalAdmin
        ];
        $listAdmin = $this->admin->getAdmin($condition, $currentPage, $this->adminOnPage);



        $returnHTML = view('admin.pagination-admin-management', compact('listAdmin', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
    }

    public function exportCSV(Request $request)
    {
        return Excel::download(new AdminsExport($request), 'list-admin-'.preg_replace("/[ ]/", "-", date('Y-m-d H:i:s')).'.csv');
    }

    public function importCSV(ImportCsvFileRequest $request)
    {
        Excel::import(new AdminsImport, $request->filecsv);

        return redirect()->back();
    }
}
