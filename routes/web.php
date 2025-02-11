<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\ProspectEnquiryController;
use App\Http\Controllers\ProspectNotesController;
use App\Http\Controllers\TankSaleController;
use App\Http\Controllers\UserCalendarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTargetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/{user?}', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/prospects', [ProspectController::class, 'index'])->name('prospects.index');
    Route::post('/prospects', [ProspectController::class, 'store'])->name('prospects.store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/prospects/{prospect}', [ProspectEnquiryController::class, 'index'])->name('company.profile');
    Route::get('/prospects/{prospect}/notes', [ProspectNotesController::class, 'index'])->name('prospect.notes');
    Route::post('/prospects/{prospect}/notes', [ProspectNotesController::class, 'store'])->name('notes.store');
    Route::get('/prospects/{prospect}/tank-sales', [TankSaleController::class, 'index'])->name('tank-sales');
    Route::post('/prospects/{prospect}/tank-sales', [TankSaleController::class, 'store'])->name('tank-sales.store');
    Route::patch('/prospects/{prospect}/tank-sales/{tankSale}', [TankSaleController::class, 'update'])->name('tank-sales.update');
    Route::patch('/prospects/{prospect}', [ProspectEnquiryController::class, 'update'])->name('prospects.update');
    Route::patch('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
    Route::post('/orders/search', [OrderController::class, 'search'])->name('orders.search');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/prospects/{prospect}/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/user-targets', [UserTargetController::class, 'index'])->name('user-targets.index');
    Route::post('/user-targets', [UserTargetController::class, 'store'])->name('user-targets.store');
    Route::patch('/user-targets/{userTarget}', [UserTargetController::class, 'update'])->name('user-targets.update');
    Route::post('/prospects/search', [ProspectController::class, 'search'])->name('prospects.search');
    Route::post('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::get('/user-calendar', [UserCalendarController::class, 'index'])->name('user-calendar.index');
    Route::post('/user-calendar.search', [UserCalendarController::class, 'search'])->name('user-calendar.search');
    Route::patch('/user-calendar/{note}', [UserCalendarController::class, 'update'])->name('user-calendar.update');
    Route::get('/advanced-search/companies', [CustomerDataController::class, 'advancedSearch'])
        ->name('companies.advanced-search');
    Route::get('/customer-data/search', [CustomerDataController::class, 'search']);
    Route::resource('customer-data', CustomerDataController::class);
});

require __DIR__.'/auth.php';
