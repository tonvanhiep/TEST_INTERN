<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportCsvFileRequest;
use App\Imports\CustomersImport;
use App\Imports\ValidateCustomerFile;
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
        $nameRoute = $request->route()->getName();
        $page = 1;
        $condition = array(
            'is_active' => (! $request->has('is_active') ? -1 : $request->is_active),
            'name' => (! $request->has('name') ? null : $request->name),
            'address' => (! $request->has('address') ? null : $request->address),
            'email' => (! $request->has('email') ? null : $request->email)
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
        return view('admin.customer-management', compact('listCustomer', 'record', 'totalPage', 'currentPage', 'nameRoute'));
    }

    public function paginationCustomer(Request $request)
    {
        $condition = array(
            'is_active' => (! $request->has('is_active') ? -1 : $request->is_active),
            'name' => (! $request->has('name') ? null : $request->name),
            'address' => (! $request->has('address') ? null : $request->address),
            'email' => (! $request->has('email') ? null : $request->email)
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
            'email' => 'required|regex:/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/|email|min:10|max:255',
            'is_active' => 'required|min:0|max:1',
            'address' => 'required',
            'tel' => 'required|numeric|digits_between:9,15'
        ], [
            'min' => ':attribute は :min 文字以上である必要があります。',
            'max' => ':attribute  は :max 文字以内である必要があります。',
            'unique' => ':attributeの値は既に存在しています。',
            'required' => ':attribute は 必要です。',
            'email' => ':attributeには、有効なメールアドレスを指定してください。',
            'numeric' => ':attributeには、数字を指定してください。',
            'digits_between' => ':attributeは:min桁から:max桁の間で指定してください。'
        ]);

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
            'id' => 'required|numeric|min:0'
        ], [
            'min' => ':attribute は :min 文字以上である必要があります。',
            'required' => ':attribute は 必要です。',
            'numeric' => ':attributeには、数字を指定してください。',
        ]);
        $this->customer->deleteCustomer($request->id);
    }

    public function searchCustomer(Request $request)
    {
        $condition = array(
            'is_active' => (! $request->has('is_active') ? -1 : $request->is_active),
            'name' => (! $request->has('name') ? null : $request->name),
            'address' => (! $request->has('address') ? null : $request->address),
            'email' => (! $request->has('email') ? null : $request->email)
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

    public function exportCSV(Request $request)
    {
        return Excel::download(new CustomersExport($request), 'list-customers-'.preg_replace("/[ ]/", "-", date('Y-m-d H:i:s')).'.csv');
    }

    public function importCSV(ImportCsvFileRequest $request)
    {
        $validator = new ValidateCustomerFile();
        Excel::import($validator, $request->filecsv);
        if (count($validator->errors)) {
            $errors = [];
            foreach ($validator->errors as $key => $error) {
                $errors[$key] = $error;
            }
            (new CustomersImport($errors))->queue($request->filecsv);
            return redirect()->back()->with('error', $errors);
        } elseif (! $validator->isValidFile) {
            return redirect()->back()->with('success', 'ファイルのアップロード成功');
        }

        (new CustomersImport())->queue($request->filecsv);

        return redirect()->back()->with('success', 'ファイルのアップロード成功');
    }
}
