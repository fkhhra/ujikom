<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Cashier;
use App\Http\Controllers\Courier;
use App\Http\Controllers\Customer;
use App\Http\Middleware\EnsureCustomerEmailIsVerified;

/*
|--------------------------------------------------------------------------
| Public & Landing Routes
|--------------------------------------------------------------------------
*/
Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/tracking', 'trackingPage')->name('tracking');
    Route::post('/track', 'track')->name('track');
    Route::post('/check-rate', 'checkRate')->name('check-rate');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {

    Route::get('/staff/login', 'showStaffLogin')->name('staff.login');
    Route::post('/staff/login', 'staffLogin')->name('staff.login.post');


    Route::get('/login', 'showCustomerLogin')->name('customer.login');
    Route::post('/login', 'customerLogin')->name('customer.login.post');
    Route::get('/register', 'showCustomerRegister')->name('customer.register');
    Route::post('/register', 'customerRegister')->name('customer.register.post');


    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Customer Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:customer'])->prefix('email')->name('customer.verification.')->group(function () {
    Route::get('/verify', function () {
        return view('auth.verify-notice');
    })->name('notice');

    Route::get('/verify/{id}/{hash}', [AuthController::class, 'verifyCustomerEmail'])
        ->middleware('signed')
        ->name('verify');

    Route::post('/verification-notification', [AuthController::class, 'resendCustomerVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('send');
});

/*
|--------------------------------------------------------------------------
| Profile & Security (Multi-Guard Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web,customer'])->prefix('profile')->name('profile.')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::delete('/photo', 'removePhoto')->name('remove-photo');
        Route::post('/security', 'updatePassword')->name('update-password');
    });
});

/*
|--------------------------------------------------------------------------
| Admin / Manager Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['role:admin'])->group(function () {
        Route::resource('branches', Admin\BranchController::class)->except(['show']);
        Route::resource('rates',    Admin\RateController::class)->except(['show']);
    });

    Route::resource('users',    Admin\UserController::class)->except(['show']);
    Route::resource('vehicles', Admin\VehicleController::class)->except(['show']);
    Route::post('/users/{id}/restore', [Admin\UserController::class, 'restore'])->name('users.restore');


    Route::controller(Admin\ShipmentController::class)->prefix('shipments')->name('shipments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{shipment}', 'show')->name('show');
        Route::post('/{shipment}/assign-courier', 'assignCourier')->name('assign-courier');
        Route::post('/{shipment}/cancel', 'cancel')->name('cancel');
    });


    Route::controller(Admin\ReportController::class)->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/generate', 'generate')->name('generate');
    });


    Route::controller(Admin\PaymentController::class)->prefix('payments')->name('payments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{payment}/print-receipt', 'printReceipt')->name('print-receipt');
    });
});

/*
|--------------------------------------------------------------------------
| Cashier Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cashier')->name('cashier.')->middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/dashboard', [Cashier\DashboardController::class, 'index'])->name('dashboard');


    Route::controller(Cashier\ShipmentController::class)->group(function () {
        Route::prefix('shipments')->name('shipments.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/scan', 'scan')->name('scan');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{shipment}', 'show')->name('show');
            Route::get('/{shipment}/print-waybill', 'printWaybill')->name('print-waybill');
            Route::post('/{shipment}/receive', 'receive')->name('receive');
            Route::post('/{shipment}/pay-cash', 'payCash')->name('pay-cash');
            Route::get('/{shipment}/payment-status', 'checkPaymentStatus')->name('payment-status');
        });
        Route::post('/customers/quick-store', 'storeCustomer')->name('customers.quick-store');
    });


    Route::controller(Cashier\PaymentController::class)->prefix('payments')->name('payments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{shipment}/create', 'create')->name('create');
        Route::post('/{shipment}/cash', 'store')->name('cash');
        Route::get('/{payment}/print-receipt', 'printReceipt')->name('print');
    });
});

/*
|--------------------------------------------------------------------------
| Courier Routes
|--------------------------------------------------------------------------
*/
Route::prefix('courier')->name('courier.')->middleware(['auth', 'role:courier'])->group(function () {
    Route::controller(Courier\ShipmentController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::prefix('shipments')->name('shipments.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{shipment}', 'show')->name('show');
            Route::post('/{shipment}/update-status', 'updateStatus')->name('update-status');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->middleware(['auth:customer'])->group(function () {
    Route::middleware([EnsureCustomerEmailIsVerified::class])->group(function () {

        Route::controller(Customer\DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/track/{shipment}', 'track')->name('track');
        });


        Route::controller(Customer\PaymentController::class)->prefix('payments')->name('payments.')->group(function () {
            Route::post('/pay/{shipment}', 'pay')->name('pay');
            Route::get('/{payment}/checkout', 'checkout')->name('checkout');
            Route::get('/{payment}/status', 'checkStatus')->name('status');
            Route::get('/{payment}/download-qris', 'downloadQris')->name('download-qris');
        });
    });
});

