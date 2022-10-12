<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $condition = [
            'is_sales' => 1,
            'name' => null,
            'min_price' => null,
            'max_price' => null
        ];
        $product = new ProductModel();
        $list = $product->getViewProduct();
        return view('client.home', compact('list'));
    }

    public function cart()
    {
        return view('client.cart');
    }

    public function checkOut()
    {
        return view('client.checkout');
    }

    public function thankYou()
    {
        return view('client.thankyou');
    }

    public function contact()
    {
        return view('client.contact');
    }

    public function saveContact(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'message' => 'required'
            ]
        );

        $data = [
            'name' => $request->lname . ' ' . $request->fname,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message
        ];

        $contact = new ContactModel();
        $contact->addContact($data);

        return redirect()->back()->with('status', 'Send message success!!!');
    }

    public function saveCartDB(Request $request)
    {

    }
}
