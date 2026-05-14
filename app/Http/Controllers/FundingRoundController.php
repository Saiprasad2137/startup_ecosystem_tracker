<?php

namespace App\Http\Controllers;

use App\Models\FundingRound;
use App\Models\Startup;
use Illuminate\Http\Request;

class FundingRoundController extends Controller
{
    public function store(Request $request, Startup $startup)
    {
        $validated = $request->validate([
            'round_name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
        ]);

        $startup->fundingRounds()->create($validated);

        return back()->with('success', 'Funding round added successfully.');
    }

    public function destroy(FundingRound $fundingRound)
    {
        $fundingRound->delete();
        return back()->with('success', 'Funding round removed.');
    }
}
