<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

class CustomerManagermentController extends Controller
{
    private $customer;
    public $customerOnPage = 20;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    public function index($page = 1)
    {
        $page = ($page >= 1) ? $page : 1;
        $totalCustomer = $this->customer->getCountCustomer();
        $totalPage = intval($totalCustomer / $this->customerOnPage + 1);
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->customerOnPage + 1,
            'max' => ($currentPage * $this->customerOnPage <= $totalCustomer) ? ($currentPage * $this->customerOnPage) : $totalCustomer,
            'total' => $totalCustomer
        ];
        $listCustomer = $this->customer->getCustomer($currentPage, $this->customerOnPage);
        return view('admin.customer-managerment', compact('listCustomer', 'record', 'totalPage', 'currentPage'));
    }
}
