<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\ProspectEnquiryController;
use App\Http\Controllers\ProspectNotesController;
use App\Http\Controllers\TankSaleController;
use App\Http\Controllers\UserController;
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
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/prospects/{prospect}', [ProspectEnquiryController::class, 'index'])->name('company.profile');
    Route::get('/prospects/{prospect}/notes', [ProspectNotesController::class, 'index'])->name('prospect.notes');
    Route::post('/prospects/{prospect}/notes', [ProspectNotesController::class, 'store'])->name('notes.store');
    Route::get('/prospects/{prospect}/tank-sales', [TankSaleController::class, 'index'])->name('tank-sales');
    Route::patch('/prospects/{prospect}', [ProspectEnquiryController::class, 'update'])->name('prospects.update');
    Route::patch('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/prospects/{prospect}/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
});

require __DIR__.'/auth.php';
