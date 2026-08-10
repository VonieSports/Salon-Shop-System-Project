<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/seller_centre', function() {return redirect()->livewire('owner.login.page');})->name('seller_centre');
Route::livewire('/', 'pages::public.home')->name('index.page');
Route::livewire('/login', 'pages::public_auth.login')->name('login');
Route::livewire('/admin/login', 'pages::admin_auth.login')->name('admin.login.page');
Route::livewire('/seller_centre', 'pages::owner_auth.login')->name('owner.login.page');
Route::livewire('/become_seller', 'pages::owner_auth.register')->name('owner.register.page');
Route::livewire('/register', 'pages::public_auth.register')->name('register.page');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('customer')->middleware(['auth', 'customer'])->group(function () {
Route::livewire('/dashboard', 'pages::customer.dashboard')->name('customer.dashboard');
Route::livewire('/profile', 'pages::customer.profile')->name('customer.profile');
Route::livewire('/update/profile', 'pages::customer.update-profile')->name('customer.update_profile');
Route::livewire('/cart', 'pages::customer.cart')->name('customer.cart');
Route::livewire('/item/{post}', 'pages::customer.item-detail')->name('customer.item_detail');
Route::livewire('/checkout', 'pages::customer.checkout')->name('customer.checkout');
Route::livewire('/track_order/{order}', 'pages::customer.track-order')->name('customer.track_order');
Route::livewire('/order_history', 'pages::customer.order-history')->name('customer.order_history');
Route::livewire('/notification_history', 'pages::customer.notification-history')->name('customer.notification_history');
Route::livewire('/payment_demo/{linkId}', 'pages::customer.payment-demo')->name('customer.payment_demo');
Route::get('/customer/payment/{order}/paymongo', [\App\Http\Controllers\PaymongoPaymentController::class, 'checkout'])->name('customer.payment.paymongo');
Route::get('/customer/payment/demo/{linkId}', [\App\Http\Controllers\PaymongoPaymentController::class, 'demoCheckout'])->name('customer.payment.demo');
Route::post('/customer/payment/demo/{linkId}/confirm', [\App\Http\Controllers\PaymongoPaymentController::class, 'demoConfirm'])->name('customer.payment.demo.confirm');
Route::post('/webhooks/paymongo', [\App\Http\Controllers\PaymongoWebhookController::class, 'handle']);
});

Route::middleware(['auth', 'track.activity'])->group(function () {
Route::prefix('owner')->middleware(['owner'])->group(function () {
Route::livewire('/dashboard', 'pages::salon_owner.dashboard')->name('owner.dashboard');
Route::livewire('/profile', 'pages::salon_owner.profile')->name('owner.profile');
Route::livewire('/business_info', 'pages::salon_owner.business-info')->name('owner.business_info');
Route::livewire('/business_setup', 'pages::salon_owner.business-setup')->name('owner.business_setup');
Route::livewire('/update/profile', 'pages::salon_owner.update-profile')->name('owner.update_profile');
Route::livewire('/business/approval', 'pages::salon_owner.business-approval')->name('owner.business_approval');
Route::livewire('/business/rejected', 'pages::salon_owner.business-rejected')->name('owner.business_rejected');   
Route::middleware('setup.complete')->group(function () {
Route::livewire('/employee', 'pages::salon_owner.employee')->name('owner.employee');
Route::livewire('/account', 'pages::salon_owner.account')->name('owner.account');
Route::livewire('/employee/schedule', 'pages::salon_owner.employee-schedule')->name('owner.employee_schedule');
Route::livewire('/create/employee', 'pages::salon_owner.create-employee')->name('owner.create_employee');
Route::livewire('/create/product', 'pages::salon_owner.create-product')->name('owner.create_product');
Route::livewire('/create/service', 'pages::salon_owner.create-service')->name('owner.create_service');
Route::livewire('/create/walkin', 'pages::salon_owner.create-walkin-customer')->name('owner.create_walkin');
Route::livewire('/create/branch', 'pages::salon_owner.create-branch')->name('owner.create_branch');
Route::livewire('/update/employee/{id}', 'pages::salon_owner.update-employee')->name('owner.update_employee');
Route::livewire('/update/product/{id}', 'pages::salon_owner.update-product')->name('owner.update_product');
Route::livewire('/update/service/{id}', 'pages::salon_owner.update-service')->name('owner.update_service');
Route::livewire('/product/management', 'pages::salon_owner.product-management')->name('owner.product_management');
Route::livewire('/service/management', 'pages::salon_owner.service-management')->name('owner.service_management');
Route::livewire('/categories/{type?}', 'pages::salon_owner.category-management')->name('owner.category_management');
Route::livewire('/inventory', 'pages::salon_owner.inventory')->name('owner.inventory');
Route::livewire('/branch/table', 'pages::salon_owner.branch-table')->name('owner.branch_table');
Route::livewire('/archive', 'pages::salon_owner.archive')->name('owner.archive');
Route::livewire('/settings', 'pages::salon_owner.setting')->name('owner.setting');
Route::livewire('/notification', 'pages::salon_owner.notification')->name('owner.notification');
Route::livewire('/customer/review', 'pages::salon_owner.customer-review')->name('owner.customer_review');
Route::livewire('/customer/orders', 'pages::salon_owner.customer-order-management')->name('owner.customer_orders');
Route::livewire('/customer/appointments', 'pages::salon_owner.customer-appointment-management')->name('owner.customer_appointments');
Route::livewire('/walkin', 'pages::salon_owner.walkin-customer')->name('owner.walkin_customer');
});
});
Route::prefix('employee')->middleware(['employee'])->group(function () {
Route::livewire('/dashboard', 'pages::employee.dashboard')->name('employee.dashboard');
Route::livewire('/profile', 'pages::employee.profile')->name('employee.profile');
Route::livewire('/update/profile', 'pages::employee.update-profile')->name('employee.update_profile');
Route::livewire('/business_info', 'pages::employee.business-info')->name('employee.business_info');
Route::livewire('/business_setup', 'pages::employee.business-setup')->name('employee.business_setup');
Route::livewire('/account', 'pages::employee.account')->name('employee.account');
Route::livewire('/branch/table', 'pages::employee.branch-table')->name('employee.branch_table');
Route::livewire('/category/management', 'pages::employee.category-management')->name('employee.category_management');
Route::livewire('/create/branch', 'pages::employee.create-branch')->name('employee.create_branch');
Route::livewire('/create/employee', 'pages::employee.create-employee')->name('employee.create_employee');
Route::livewire('/create/walkin', 'pages::employee.create-walkin')->name('employee.create_walkin');
Route::livewire('/create/product', 'pages::employee.create-product')->name('employee.create_product');
Route::livewire('/create/service', 'pages::employee.create-service')->name('employee.create_service');
Route::livewire('/customer/review', 'pages::employee.customer-review')->name('employee.customer_review');
Route::livewire('/schedule', 'pages::employee.employee-schedule')->name('employee.employe_schedule');
Route::livewire('/inventory', 'pages::employee.inventory')->name('employee.inventory');
Route::livewire('/notification', 'pages::employee.notification')->name('employee.notification');
Route::livewire('/product/management', 'pages::employee.product-management')->name('employee.product_management');
Route::livewire('/service/management', 'pages::employee.servie-management')->name('employee.service_management');
Route::livewire('/update/employee', 'pages::employee.update-employee')->name('employee.update_employee');   
Route::livewire('/update/product', 'pages::employee.update-product')->name('employee.update_product');
Route::livewire('/update/service', 'pages::employee.update-service')->name('employee.update_service');
Route::livewire('/inventory', 'pages::employee.inventory')->name('employee.inventory');                               
});
});
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
Route::livewire('/profile', 'pages::admin.profile')->name('admin.profile');
Route::livewire('/update/profile', 'pages::admin.update-profile')->name('admin.update_profile');
Route::livewire('/business/approvals', 'pages::admin.business-approval')->name('admin.business_approvals');
Route::livewire('/shop/management', 'pages::admin.shop-management')->name('admin.shop_management');
Route::livewire('/shop/customer', 'pages::admin.shop-customer')->name('admin.shop_customer');
});