<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startups = Startup::all();
        return view('startups.index', compact('startups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('startups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'stage' => 'nullable|string|max:255',
            'funding_raised' => 'nullable|numeric|min:0',
        ]);

        Startup::create($validated);
        return redirect()->route('startups.index')->with('success', 'Startup created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Startup $startup)
    {
        $startup->load(['founders', 'fundingRounds.investors']);
        return view('startups.show', compact('startup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Startup $startup)
    {
        return view('startups.edit', compact('startup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Startup $startup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'stage' => 'nullable|string|max:255',
            'funding_raised' => 'nullable|numeric|min:0',
        ]);

        $startup->update($validated);
        return redirect()->route('startups.index')->with('success', 'Startup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Startup $startup)
    {
        $startup->delete();
        return redirect()->route('startups.index')->with('success', 'Startup deleted successfully.');
    }
}
