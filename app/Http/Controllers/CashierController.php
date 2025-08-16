<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Rental;
use App\Models\RentalPackage;
use Inertia\Inertia;

class CashierController extends Controller
{
    /**
     * Display the cashier dashboard.
     */
    public function index()
    {
        $activeRentals = Rental::with(['console', 'customer'])
            ->active()
            ->get()
            ->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'console_name' => $rental->console->name,
                    'customer_name' => $rental->customer->name,
                    'start_time' => $rental->start_time,
                    'end_time' => $rental->end_time,
                    'remaining_time' => $rental->remaining_time,
                    'is_overdue' => $rental->isOverdue(),
                    'total_amount' => $rental->total_amount,
                    'paid_amount' => $rental->paid_amount,
                    'payment_status' => $rental->payment_status,
                ];
            });

        $availableConsoles = Console::available()
            ->where('is_online', true)
            ->count();

        $totalActiveRentals = $activeRentals->count();
        $overdueRentals = $activeRentals->where('is_overdue', true)->count();

        return Inertia::render('cashier/dashboard', [
            'activeRentals' => $activeRentals,
            'stats' => [
                'available_consoles' => $availableConsoles,
                'active_rentals' => $totalActiveRentals,
                'overdue_rentals' => $overdueRentals,
            ],
        ]);
    }
}