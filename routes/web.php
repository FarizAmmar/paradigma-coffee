<?php

use App\Events\CartEvents;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\Menu;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Guest Menu
Route::get('/', [HomeController::class, 'index'])->name('guest.menu')->middleware('guest');
Route::get('/reset', [HomeController::class, 'resetCookie'])->name('reset.cookie')->middleware('guest');
Route::get('/inovice', [HomeController::class, 'invoice'])->name('guest.invoice')->middleware('guest');

// Guest Cart Desktop
Route::post('/order/menu/{uuid}/{menu_id}', [CartController::class, 'store'])->middleware('guest')->name('cart.store');
Route::get('/order/menu/update/{uuid}/{menu_id}/{qty}', [CartController::class, 'UpdateQuantity'])->middleware('guest')->name('cart.update.qty');

// Guest Cart
Route::get('/order/checkout', [CheckoutController::class, 'index'])->name('guest.cart')->middleware('guest');
Route::post('/order/checkout/store', [CheckoutController::class, 'store'])->name('guest.cart.store')->middleware('guest');
Route::post('/order/checkout/table', [CheckoutController::class, 'save_table'])->name('guest.cart.table')->middleware('guest');
Route::get('/order/checkout/{uuid}/{payment}', [CheckoutController::class, 'payment'])->name('guest.cart.payment')->middleware('guest');

// Login
Route::get('/employee/login', [UserController::class, 'login'])->name('emp.login')->middleware('guest');
Route::post('/employee/login', [UserController::class, 'authenticate'])->name('emp.login.auth');

// Logout
Route::get('logout', [UserController::class, 'logout'])->name('emp.logout');

// Employee
Route::middleware('auth')->group(function () {
    // Employee CRUD
    Route::get('/dashboard/employee/', [DashboardController::class, 'index'])->name('emp.home');
    Route::post('/dashboard/employee/new', [DashboardController::class, 'store'])->name('emp.store');
    Route::post('/dashboard/employee/update/{id}', [DashboardController::class, 'update'])->name('emp.update');
    Route::delete('/dashboard/employee/delete/{id}', [DashboardController::class, 'destroy'])->name('emp.delete');

    // Category CRUD
    Route::get('/menu/category', [CategoryController::class, 'index'])->name('menu.cat');
    Route::post('/menu/category/new', [CategoryController::class, 'store'])->name('menu.cat.store');
    Route::post('/menu/category/update/{code}', [CategoryController::class, 'update'])->name('menu.cat.update');
    Route::delete('/menu/category/delete/{code}', [CategoryController::class, 'destroy'])->name('menu.cat.delete');

    // Menu CRUD
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.menus');
    Route::post('/menu/new', [MenuController::class, 'store'])->name('menu.menus.store');
    Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.menus.update');
    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.menus.delete');

    // Order CRUD
    Route::get('/order/waiting-list', [CheckoutController::class, 'waitingList'])->name('order.waiting');
    Route::get('/order', [CheckoutController::class, 'order'])->name('order.listing.paid');
    Route::get('/order/waiting-list/status/{uuid}/{status}/{menu_id}', [CheckoutController::class, 'orderStatus'])->name('order.status');
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::post('/report', [ReportController::class, 'index'])->name('report.search');
    Route::get('/report/print/{fromdate}/{todate}', [ReportController::class, 'generatePdf'])->name('print');
});

// Get menu
Route::get('/get-menu/{menu_id}', function (string $menu_id) {
    $menu = Menu::find($menu_id);

    return response()->json($menu);
});
