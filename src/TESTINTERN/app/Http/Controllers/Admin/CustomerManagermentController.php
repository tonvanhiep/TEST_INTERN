<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

class CustomerManagermentController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    public function index()
    {
        $listCustomer = $this->customer->getAllCustomer();
        // dd($listCustomer);
        return view('admin.customer-managerment', compact('listCustomer'));
    }
}
