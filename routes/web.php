<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $products = Product::paginate(6);
    return view('dashboard')->with([
        'products' => $products
    ]);
})->name('dashboard');

Route::get('/searchh', [UserController::class, 'search'])->name('products.search');


Route::middleware('admin')->group(function () {
  Route::get('admin.dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
  Route::get('add/product', [AdminController::class, 'create'])->name('admin.create');
  Route::post('add/product', [AdminController::class, 'store'])->name('admin.store');
  Route::get('edit/product/{product}', [AdminController::class, 'edit'])->name('admin.edit');
  Route::put('edit/product/{product}', [AdminController::class, 'update'])->name('admin.update');
  Route::delete('delete/product/{product}', [AdminController::class, 'destroy'])->name('admin.delete');
  Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
  Route::get('/all-orders', [AdminController::class, 'show'])->name('admin.orders');
  Route::put('/update-status/{order}', [AdminController::class, 'updatestatus'])->name('admin.orders.status');
  Route::delete('/delete/order/{order}', [AdminController::class, 'delete'])->name('order.delete');
  Route::get('/search-orders', [AdminController::class, 'searchOrders'])->name('admin.orders.search');
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/shipping', [OrderController::class, 'index'])->name('order.shipping');
    Route::post('/cart/shipping', [OrderController::class, 'itemsprocess'])->name('items.process');
    Route::get('/orders', [OrderController::class, 'show'])->name('order.index');
});

require __DIR__.'/auth.php';
