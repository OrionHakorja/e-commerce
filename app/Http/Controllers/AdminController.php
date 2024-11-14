<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::paginate(6);
        return view('admin.dashboard')->with([
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Validate input fields, including 'image' as an image file
        $data = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);



        // Save product data, including the image path
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->description = $request->description;
        $product->image = 'images/'.$imageName;
        $product->save();

        // Redirect with success message
        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit')->with([
            'product' => $product
        ]);
    }

    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->type = $data['type'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/services'), $filename);
            $product->image = 'images/services/' . $filename; // Store the full path
        }

        $product->save();

        return redirect()->route('admin.dashboard')->with('success', 'Product edited successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();

        return view('admin.dashboard', compact('products'));
    }
    public function show()
    {
        $orders = Order::paginate(5);
        return view('admin.order.index')->with([
            'orders' => $orders
        ]);
    }

    public function searchOrders(Request $request)
    {
        $search = $request->search;

        $orders = Order::query()->where('id', 'LIKE', "%$search%")
            ->orWhere('name', 'LIKE', "%$search%")
        ->orWhere('address', 'LIKE', "%$search%")
        ->orWhere('email', 'LIKE', "%$search%")
        ->orWhere('payment_method', 'LIKE', "%$search%")
            ->orWhere('total_price', 'LIKE', "%$search%")
        ->orWhere('user_id', 'LIKE', "%$search%")
            ->orWhere('status', 'LIKE', "%$search%")->get();

        return view('admin.order.index')->with([
            'orders' => $orders
        ]);
    }
public function updatestatus(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->route('admin.orders')->with('success', 'Order successfully updated');
}
public function delete($id)
{
    $order = Order::findOrFail($id);
    $order->delete();
    return redirect()->route('admin.orders')->with('success', 'Order successfully deleted');

}

}
