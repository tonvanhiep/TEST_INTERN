<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\CustomersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class CustomerManagermentController extends Controller
{
    private $customer;
    public $customerOnPage = 20;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    public function index(Request $request)
    {
        $page = 1;
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'address' => (!$request->has('address') ? null : $request->address),
            'email' => (!$request->has('email') ? null : $request->email)
        );
        $totalCustomer = $this->customer->getCountCustomer($condition);
        $totalPage = intval($totalCustomer / $this->customerOnPage + (($totalCustomer % $this->customerOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($condition, $currentPage, $this->customerOnPage);
        return view('admin.customer-management', compact('listCustomer', 'record', 'totalPage', 'currentPage'));
    }

    public function paginationCustomer(Request $request)
    {
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'address' => (!$request->has('address') ? null : $request->address),
            'email' => (!$request->has('email') ? null : $request->email)
        );

        $page = ($request->page >= 1) ? $request->page : 1;
        $totalCustomer = $this->customer->getCountCustomer($condition);
        $totalPage = intval($totalCustomer / $this->customerOnPage + (($totalCustomer % $this->customerOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($condition, $currentPage, $this->customerOnPage);

        $returnHTML = view('admin.pagination-customer-management', compact('listCustomer', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
    }

    public function editCustomer(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0',
            'name' => 'required',
            'tel' => 'required',
            'email' => 'required|email',
            'is_active' => 'required|min:0|max:1'
            ]
        );

        $id = $request->id;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'address' => $request->address,
            'is_active' => $request->is_active
            ];
        $result = $this->customer->updateCustomer($id, $data);

        if($result['success'] == false) {
            return response()->json([
                'message' => $result['message'],
                'errors' => [
                    'email' => [$result['message']]
                ]
            ], 422);
        }
        return 'Success';
    }

    public function deleteCustomer(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0'
            ]
        );
        $this->customer->deleteCustomer($request->id);
    }

    public function searchCustomer(Request $request)
    {
        $condition = array(
            'is_active' => (!$request->has('is_active') ? -1 : $request->is_active),
            'name' => (!$request->has('name') ? null : $request->name),
            'address' => (!$request->has('address') ? null : $request->address),
            'email' => (!$request->has('email') ? null : $request->email)
        );
        $page = ($request->page >= 1) ? $request->page : 1;
        $totalCustomer = $this->customer->getCountCustomer($condition);
        $totalPage = intval($totalCustomer / $this->customerOnPage + (($totalCustomer % $this->customerOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($condition, $currentPage, $this->customerOnPage);



        $returnHTML = view('admin.pagination-customer-management', compact('listCustomer', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
    }

    public function exportCSV()
    {
        return Excel::download(new CustomersExport, 'list-customers-'.preg_replace("/[ ]/", "-", date('Y-m-d H:i:s')).'.csv');
    }

    public function importCSV(Request $request)
    {
        Excel::import(new CustomersImport, $request->filecsv);

    }
}
