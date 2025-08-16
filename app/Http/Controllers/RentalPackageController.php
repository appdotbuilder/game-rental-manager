<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentalPackageRequest;
use App\Http\Requests\UpdateRentalPackageRequest;
use App\Models\RentalPackage;
use Inertia\Inertia;

class RentalPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = RentalPackage::withCount('rentals')
            ->latest()
            ->paginate(15);

        return Inertia::render('rental-packages/index', [
            'packages' => $packages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('rental-packages/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalPackageRequest $request)
    {
        $package = RentalPackage::create($request->validated());

        return redirect()->route('rental-packages.show', $package)
            ->with('success', 'Rental package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalPackage $rentalPackage)
    {
        $rentalPackage->load(['rentals.customer', 'rentals.console']);

        return Inertia::render('rental-packages/show', [
            'package' => $rentalPackage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalPackage $rentalPackage)
    {
        return Inertia::render('rental-packages/edit', [
            'package' => $rentalPackage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentalPackageRequest $request, RentalPackage $rentalPackage)
    {
        $rentalPackage->update($request->validated());

        return redirect()->route('rental-packages.show', $rentalPackage)
            ->with('success', 'Rental package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalPackage $rentalPackage)
    {
        if ($rentalPackage->rentals()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete package with active rentals.');
        }

        $rentalPackage->delete();

        return redirect()->route('rental-packages.index')
            ->with('success', 'Rental package deleted successfully.');
    }
}