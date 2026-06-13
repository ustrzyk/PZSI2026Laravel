<?php

use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/category/{id}', [ShopController::class, 'category'])->name('shop.category');

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('user.logged')->group(function () {
    Route::post('/cart/order', [CartController::class, 'order'])->name('cart.order');
});

Route::middleware('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/edit/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/edit/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

    Route::get('/accessories', [AccessoryController::class, 'index'])->name('accessories.index');
    Route::get('/accessories/create', [AccessoryController::class, 'create'])->name('accessories.create');
    Route::post('/accessories/create', [AccessoryController::class, 'store'])->name('accessories.store');
    Route::get('/accessories/edit/{id}', [AccessoryController::class, 'edit'])->name('accessories.edit');
    Route::put('/accessories/edit/{id}', [AccessoryController::class, 'update'])->name('accessories.update');
    Route::delete('/accessories/delete/{id}', [AccessoryController::class, 'delete'])->name('accessories.delete');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/edit/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/edit/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/delete/{id}', [OrderController::class, 'delete'])->name('orders.delete');

    Route::get('/order-items', [OrderItemController::class, 'index'])->name('order-items.index');
    Route::get('/order-items/create', [OrderItemController::class, 'create'])->name('order-items.create');
    Route::post('/order-items/create', [OrderItemController::class, 'store'])->name('order-items.store');
    Route::get('/order-items/edit/{id}', [OrderItemController::class, 'edit'])->name('order-items.edit');
    Route::put('/order-items/edit/{id}', [OrderItemController::class, 'update'])->name('order-items.update');
    Route::delete('/order-items/delete/{id}', [OrderItemController::class, 'delete'])->name('order-items.delete');
});