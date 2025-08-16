<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\Rental;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Revenue reports
        $totalRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $rentalRevenue = Rental::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $productRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->whereNull('rental_id')
            ->sum('total_amount');

        // Daily revenue chart
        $dailyRevenue = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Console utilization
        $consoleUtilization = Console::withCount([
                'rentals' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            ])
            ->with(['rentals' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                      ->selectRaw('console_id, SUM(TIMESTAMPDIFF(HOUR, start_time, COALESCE(actual_end_time, end_time))) as total_hours')
                      ->groupBy('console_id');
            }])
            ->get()
            ->map(function ($console) {
                $totalHours = $console->rentals->first()->total_hours ?? 0;
                return [
                    'name' => $console->name,
                    'type' => $console->type,
                    'rental_count' => $console->rentals_count,
                    'total_hours' => $totalHours,
                    'utilization_rate' => $totalHours > 0 ? round(($totalHours / 24) * 100, 2) : 0,
                ];
            });

        // Top customers
        $topCustomers = DB::table('customers')
            ->join('rentals', 'customers.id', '=', 'rentals.customer_id')
            ->whereBetween('rentals.created_at', [$startDate, $endDate])
            ->select(
                'customers.name',
                DB::raw('COUNT(rentals.id) as rental_count'),
                DB::raw('SUM(rentals.total_amount) as total_spent')
            )
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        // Payment analysis
        $paymentAnalysis = [
            'on_time' => Rental::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'paid')
                ->count(),
            'partial' => Rental::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'partial')
                ->count(),
            'pending' => Rental::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'pending')
                ->count(),
        ];

        return Inertia::render('reports/index', [
            'dateRange' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'rental' => $rentalRevenue,
                'product' => $productRevenue,
                'daily_chart' => $dailyRevenue,
            ],
            'consoleUtilization' => $consoleUtilization,
            'topCustomers' => $topCustomers,
            'paymentAnalysis' => $paymentAnalysis,
        ]);
    }

    /**
     * Store a new report export request.
     */
    public function store(Request $request)
    {
        $format = $request->input('format', 'pdf');
        $type = $request->input('type', 'summary');
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // This is a placeholder for actual export functionality
        // In a real implementation, you would use libraries like:
        // - dompdf or wkhtmltopdf for PDF export
        // - Laravel Excel for Excel export
        // - League CSV for CSV export

        $data = [
            'type' => $type,
            'format' => $format,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'generated_at' => now(),
            'message' => 'Report export functionality would be implemented here with appropriate libraries.',
        ];

        return response()->json($data);
    }
}