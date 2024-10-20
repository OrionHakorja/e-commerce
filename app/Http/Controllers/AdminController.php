<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
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
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        Product::create($data);
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
        $product->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Product editted successfully');
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

}
