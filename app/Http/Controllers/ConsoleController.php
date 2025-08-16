<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsoleRequest;
use App\Http\Requests\UpdateConsoleRequest;
use App\Models\Console;
use Inertia\Inertia;

class ConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consoles = Console::withCount(['rentals' => function ($query) {
                $query->whereMonth('created_at', now()->month);
            }])
            ->latest()
            ->paginate(15);

        return Inertia::render('consoles/index', [
            'consoles' => $consoles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('consoles/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsoleRequest $request)
    {
        $console = Console::create($request->validated());

        return redirect()->route('consoles.show', $console)
            ->with('success', 'Console created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Console $console)
    {
        $console->load(['rentals.customer', 'fraudDetections']);

        return Inertia::render('consoles/show', [
            'console' => $console,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Console $console)
    {
        return Inertia::render('consoles/edit', [
            'console' => $console,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsoleRequest $request, Console $console)
    {
        $console->update($request->validated());

        return redirect()->route('consoles.show', $console)
            ->with('success', 'Console updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Console $console)
    {
        if ($console->status === 'rented') {
            return back()->with('error', 'Cannot delete a console that is currently rented.');
        }

        $console->delete();

        return redirect()->route('consoles.index')
            ->with('success', 'Console deleted successfully.');
    }
}