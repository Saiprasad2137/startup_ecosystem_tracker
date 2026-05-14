<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $startups = $request->user()->portfolio()->with(['founders', 'fundingRounds.investors'])->get();
        return view('portfolio.index', compact('startups'));
    }

    public function toggle(Request $request, Startup $startup)
    {
        $request->user()->portfolio()->toggle($startup->id);
        return back();
    }
}
