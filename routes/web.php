<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Menu
Route::get('/', [HomeController::class, 'index'])->name('guest.menu')->middleware('guest');

// Cart
Route::get('/order/checkout', [CheckoutController::class, 'index'])->name('guest.cart')->middleware('guest');

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
});
