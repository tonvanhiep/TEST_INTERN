<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomerManagermentController extends Controller
{
    private $customer;
    public $customerOnPage = 20;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    public function index()
    {
        $page = 1;
        $totalCustomer = $this->customer->getCountCustomer();
        $totalPage = intval($totalCustomer / $this->customerOnPage + (($totalCustomer % $this->customerOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($currentPage, $this->customerOnPage);
        return view('admin.customer-management', compact('listCustomer', 'record', 'totalPage', 'currentPage'));
    }

    public function paginationCustomer(Request $request)
    {
        $page = ($request->page >= 1) ? $request->page : 1;
        $totalCustomer = $this->customer->getCountCustomer();
        $totalPage = intval($totalCustomer / $this->customerOnPage + (($totalCustomer % $this->customerOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($currentPage, $this->customerOnPage);

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
            return Redirect::back()->withErrors(['msg' => $request['massage']]);
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
}
