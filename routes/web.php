<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::livewire('/', 'pages::public.home')->name('index.page');
Route::livewire('/login', 'pages::public_auth.login')->name('login.page');
Route::livewire('/seller_centre', 'pages::owner_auth.login')->name('owner.login.page');
Route::livewire('/become_seller', 'pages::owner_auth.register')->name('owner.register.page');
Route::livewire('/register', 'pages::public_auth.register')->name('register.page');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
});

Route::prefix('owner')->middleware(['auth', 'owner'])->group(function () {
    Route::livewire('/dashboard', 'pages::salon_owner.dashboard')->name('owner.dashboard');
    Route::livewire('/profile', 'pages::salon_owner.profile')->name('owner.profile');
    Route::livewire('/business_info', 'pages::salon_owner.business-info')->name('owner.business_info');
    Route::livewire('/business_setup', 'pages::salon_owner.business-setup')->name('owner.business_setup');
    Route::livewire('/update/profile', 'pages::salon_owner.update-profile')->name('owner.update_profile');
    Route::middleware('setup.complete')->group(function () {
    Route::livewire('/create/post', 'pages::salon_owner.create-post')->name('owner.create_post');
    Route::livewire('/create/product', 'pages::salon_owner.create-product')->name('owner.create_product');
    Route::livewire('/create/service', 'pages::salon_owner.create-service')->name('owner.create_service');
    Route::livewire('/update/post/{id}', 'pages::salon_owner.update-post')->name('owner.update_post');
    Route::livewire('/update/product/{id}', 'pages::salon_owner.update-product')->name('owner.update_product');
    Route::livewire('/update/service/{id}', 'pages::salon_owner.update-service')->name('owner.update_service');
    Route::livewire('/post/table', 'pages::salon_owner.post-table')->name('owner.post_table');
    Route::livewire('/product/management', 'pages::salon_owner.product-management')->name('owner.product_management');
    Route::livewire('/service/management', 'pages::salon_owner.service-management')->name('owner.service_management');
    Route::livewire('/item/management', 'pages::salon_owner.item-management')->name('owner.item_management');
    Route::livewire('/create/user', 'pages::salon_owner.create-user')->name('owner.create_user');
    });
});

Route::prefix('customer')->middleware(['auth', 'customer'])->group(function () {
    Route::livewire('/dashboard', 'pages::customer.dashboard')->name('customer.dashboard');
    Route::livewire('/profile', 'pages::customer.profile')->name('customer.profile');
    Route::livewire('/update/profile', 'pages::customer.update-profile')->name('customer.update_profile');
    Route::livewire('/cart', 'pages::customer.cart')->name('customer.cart');
});

Route::prefix('employee')->middleware(['auth', 'employee'])->group(function () {
    Route::livewire('/dashboard', 'pages::employee.dashboard')->name('employee.dashboard');
});

