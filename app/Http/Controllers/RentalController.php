<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Console;
use App\Models\Customer;
use App\Models\Rental;
use App\Models\RentalPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::with(['console', 'customer', 'rentalPackage', 'user'])
            ->latest()
            ->paginate(20);

        return Inertia::render('rentals/index', [
            'rentals' => $rentals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consoles = Console::available()
            ->where('is_online', true)
            ->get();

        $customers = Customer::orderBy('name')->get();
        $packages = RentalPackage::active()->orderBy('duration_hours')->get();

        return Inertia::render('rentals/create', [
            'consoles' => $consoles,
            'customers' => $customers,
            'packages' => $packages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();

        // Calculate end time based on package or custom duration
        $startTime = now();
        if (isset($validated['rental_package_id']) && $validated['rental_package_id']) {
            $package = RentalPackage::findOrFail($validated['rental_package_id']);
            $endTime = $startTime->copy()->addHours($package->duration_hours);
            $totalAmount = $package->price;
        } else {
            $endTime = $startTime->copy()->addHours($validated['duration_hours']);
            $console = Console::findOrFail($validated['console_id']);
            $totalAmount = $console->hourly_rate * $validated['duration_hours'];
        }

        $rental = Rental::create([
            'console_id' => $validated['console_id'],
            'customer_id' => $validated['customer_id'],
            'rental_package_id' => $validated['rental_package_id'] ?? null,
            'user_id' => auth()->id(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_amount' => $totalAmount,
            'paid_amount' => $validated['paid_amount'] ?? 0,
            'payment_status' => ($validated['paid_amount'] ?? 0) >= $totalAmount ? 'paid' : (($validated['paid_amount'] ?? 0) > 0 ? 'partial' : 'pending'),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update console status
        Console::where('id', $validated['console_id'])
            ->update(['status' => 'rented']);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        $rental->load(['console', 'customer', 'rentalPackage', 'user', 'sale.saleItems.product']);

        return Inertia::render('rentals/show', [
            'rental' => $rental,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        $rental->load(['console', 'customer', 'rentalPackage']);

        return Inertia::render('rentals/edit', [
            'rental' => $rental,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentalRequest $request, Rental $rental)
    {
        $validated = $request->validated();
        
        $rental->update($validated);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Rental updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        // Only allow deletion if rental hasn't started or is cancelled
        if ($rental->status === 'active') {
            return back()->with('error', 'Cannot delete an active rental.');
        }

        // Make console available if it was rented
        if ($rental->console->status === 'rented') {
            $rental->console->update(['status' => 'available']);
        }

        $rental->delete();

        return redirect()->route('rentals.index')
            ->with('success', 'Rental deleted successfully.');
    }
}