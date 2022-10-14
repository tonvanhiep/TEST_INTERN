<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
        if(!session()->has('id_dh'))
            return redirect()->route('home');
        $id_dh = session('id_dh');
        return view('client.thankyou', compact('id_dh'));
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
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'tel' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
            'paymentMethod' => 'required|numeric|min:1|max:3'
        ]);

        $cart = $request->cookie('cart');
        $total = $request->cookie('total');
        if($cart == null || $total == null) return;

        $arrCart = explode('/', $cart);
        $arrTotal = explode('-', $total);

        //luu vao database
        $date = date('Y-m-d H:i:s');
        $data = [
            'customer_id' => $request->session()->has('customer') ? $request->session()->get('customer')['id'] : -1,
            'customer_name' =>  $request->lastName . $request->firstName,
            'customer_email' => $request->email,
            'customer_tel' => $request->tel,
            'address' => $request->address,
            'total_price' => $arrTotal[2],
            'payment_method' => $request->paymentMethod,
            'ship_charge' => $arrTotal[1],
            'order_date' => $date,
            'note_customer' => $request->has('massage') ? $request->get('massage') : '',
            'created_at' => $date,
            'updated_at' => $date,
            'order_status' => 0
        ];

        $order = new OrderModel();
        $id_dh = $order->addOrder($data);


        for ($i = 0; $i < count($arrCart) - 1; $i++) {
            $item = explode(':', $arrCart[$i]);
            $data = [
                'order_id' => $id_dh,
                'detail_line' =>  $i,
                'product_id' => $item[0],
                'price_buy' => $item[1],
                'quantity' => $item[2],
                'created_at' => $date,
                'updated_at' => $date,
            ];

            $orderDetail = new OrderDetailModel();
            $orderDetail->addOrderDetail($data);
        }

        // xoa cookie
        setcookie('cart', '', time() - 3600);
        setcookie('total', '', time() - 3600);
        return redirect()->route('thankyou')->with('id_dh', $id_dh);
    }
}
