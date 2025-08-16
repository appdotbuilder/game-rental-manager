<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RentalPackageController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('cashier.dashboard');
    })->name('dashboard');

    // Cashier routes
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.dashboard');
    
    // Admin routes  
    Route::group(['middleware' => function ($request, $next) {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Admin access required.');
        }
        return $next($request);
    }], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('consoles', ConsoleController::class);
        Route::resource('rental-packages', RentalPackageController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    // Shared routes (both cashier and admin)
    Route::resource('rentals', RentalController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
