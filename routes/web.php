<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLineController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::get('/',        [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart/{type}', [DashboardController::class, 'chartData'])->name('dashboard.chart');

    // All resource routes — staff.readonly middleware blocks create/edit/delete for staff
    Route::middleware(['staff.readonly'])->group(function () {
        Route::resource('customers',     CustomerController::class);
        Route::resource('employees',     EmployeeController::class);
        Route::resource('offices',       OfficeController::class);
        Route::resource('orders',        OrderController::class);
        Route::resource('products',      ProductController::class);
        Route::resource('product-lines', ProductLineController::class);
        Route::resource('payments',      PaymentController::class);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});
