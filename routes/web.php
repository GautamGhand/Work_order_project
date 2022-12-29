<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PasswordSetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoderController;
use App\Http\Controllers\WorkOrderAssignController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderStatusController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::controller(LoginController::class)->group(function() {

    Route::get('/login', 'index')->name('login.index');

    Route::post('/login', 'login')->name('login');

    Route::get('/logout', 'logout')->name('logout');

});

Route::controller(CustomerController::class)->group(function () {

    Route::get('/customers/work-order', 'index')->name('customers.work-orders');

    Route::get('/customers/create', 'create')->name('customers.create');

    Route::post('/customers/store', 'store')->name('customers.store');

});

Route::middleware('auth')->group(function () {

    Route::controller(UserController::class)->group(function () {

        Route::get('/users', 'index')->name('users');

        Route::get('/users/create', 'create')->name('users.create');

        Route::post('/users/store', 'store')->name('users.store');

        Route::get('/users/{user:slug}/edit', 'edit')->name('users.edit');

        Route::post('/users/{user}/update', 'update')->name('users.update');

    });

    Route::controller(DashboardController::class)->group(function () {

        Route::get('/dashboard', 'index')->name('dashboard');

    });

    Route::controller(WorkOrderController::class)->group(function () {

        Route::get('/work-orders', 'index')->name('work-orders');

        Route::get('/work-orders/create', 'create')->name('work-orders.create');

        Route::post('/work-orders/store', 'store')->name('work-orders.store');
    });

    Route::controller(WorkOrderStatusController::class)->group(function () {

        Route::get('/work-orders/{workorder}/status/create', 'create')->name('work-order.status.create');

        Route::post('/work-orders/{workorder}/status/update', 'update')->name('work-order.status.update');

    });
    
    Route::get('/users/employees', [ManagerController::class, 'index'])->name('users.employees');

    Route::get('/users/create/employee', [EmployeeController::class, 'create'])->name('users.create.employees');

    Route::post('/users/store/employee', [EmployeeController::class, 'store'])->name('users.store.employees');

    Route::get('/set-password/{user:slug}', [PasswordSetController::class, 'index'])->name('setpassword.index');

    Route::post('/set-password/{user}', [PasswordSetController::class, 'setpassword'])->name('setpassword');
    
});


