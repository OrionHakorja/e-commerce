<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        $cartItems = session()->get('cart', []); // Fetch cart from session
        return view('cart.index', compact('cartItems'));
    }
    public function add(Request $request) {
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->id] = [
                "name" => $request->name,
                "price" => $request->price,
                "quantity" => $request->quantity
            ];
        }

        session()->put('cart', $cart); // Store cart back in session
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    public function update(Request $request) {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated!');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart!');
    }
    public function remove(Request $request) {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Product removed!');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart!');
    }
    public function clear() {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }


}
