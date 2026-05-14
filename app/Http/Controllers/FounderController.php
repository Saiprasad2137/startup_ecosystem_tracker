<?php

namespace App\Http\Controllers;

use App\Models\Founder;
use App\Models\Startup;
use Illuminate\Http\Request;

class FounderController extends Controller
{
    public function store(Request $request, Startup $startup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
        ]);

        $startup->founders()->create($validated);

        return back()->with('success', 'Founder added successfully.');
    }

    public function destroy(Founder $founder)
    {
        $founder->delete();
        return back()->with('success', 'Founder removed.');
    }
}
