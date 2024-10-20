<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.shipping');
    }

    public function itemsprocess(Request $request)
    {

        $request->validate([
        'name' => 'required',
        'address' => 'required',
        'email' => 'required',
        'payment_method' => 'required'
    ]);
        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate total price
        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
        'name' => $request->name,
        'address' => $request->address,
        'email' => $request->email,
        'payment_method' => $request->payment_method,
        'total_price' => $totalPrice
        ]);


        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $details['name'],
                'product_price' => $details['price'],
                'quantity' => $details['quantity'],
                'total' => $details['price'] * $details['quantity'],
            ]);

            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Order items successfully processed!');

        }

//        return redirect()->route('order.shipping');





        return redirect()->route('dashboard');
    }
}
