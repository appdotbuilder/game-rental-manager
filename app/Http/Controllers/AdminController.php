<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\FraudDetection;
use App\Models\Rental;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Daily sales statistics
        $dailySales = Sale::whereDate('created_at', today())
            ->sum('total_amount');

        $monthlySales = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Console statistics
        $consoleStats = [
            'total' => Console::count(),
            'available' => Console::where('status', 'available')->count(),
            'rented' => Console::where('status', 'rented')->count(),
            'maintenance' => Console::where('status', 'maintenance')->count(),
            'online' => Console::where('is_online', true)->count(),
        ];

        // Fraud detection alerts
        $fraudAlerts = FraudDetection::with(['console', 'rental'])
            ->unresolved()
            ->orderBy('detected_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($fraud) {
                return [
                    'id' => $fraud->id,
                    'console_name' => $fraud->console->name,
                    'fraud_type' => $fraud->fraud_type,
                    'description' => $fraud->description,
                    'severity' => $fraud->severity,
                    'detected_at' => $fraud->detected_at,
                ];
            });

        // Revenue chart data (last 7 days)
        $revenueChart = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top performing consoles
        $topConsoles = Console::withCount(['rentals' => function ($query) {
                $query->whereMonth('created_at', now()->month);
            }])
            ->orderBy('rentals_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($console) {
                return [
                    'name' => $console->name,
                    'type' => $console->type,
                    'rental_count' => $console->rentals_count,
                    'status' => $console->status,
                    'is_online' => $console->is_online,
                ];
            });

        return Inertia::render('admin/dashboard', [
            'stats' => [
                'daily_sales' => $dailySales,
                'monthly_sales' => $monthlySales,
                'console_stats' => $consoleStats,
                'fraud_alerts_count' => $fraudAlerts->count(),
            ],
            'fraudAlerts' => $fraudAlerts,
            'revenueChart' => $revenueChart,
            'topConsoles' => $topConsoles,
        ]);
    }
}