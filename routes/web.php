<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Fallbacks if data is empty to ensure charts render beautifully
    $startupsByStage = \App\Models\Startup::select('stage', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->whereNotNull('stage')
        ->groupBy('stage')
        ->pluck('total', 'stage')
        ->toArray();
    
    if (empty($startupsByStage)) {
        $startupsByStage = ['Idea' => 1, 'Seed' => 1]; // Demo data to show empty chart state
    }

    $recentStartups = \App\Models\Startup::latest()->take(5)->get();

    return view('dashboard', compact('startupsByStage', 'recentStartups'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/portfolio', [\App\Http\Controllers\PortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio/{startup}/toggle', [\App\Http\Controllers\PortfolioController::class, 'toggle'])->name('portfolio.toggle');
    
    Route::get('startups', [\App\Http\Controllers\StartupController::class, 'index'])->name('startups.index');

    Route::middleware('role:admin')->group(function () {
        Route::resource('startups', \App\Http\Controllers\StartupController::class)->except(['index', 'show']);
        
        Route::post('startups/{startup}/founders', [\App\Http\Controllers\FounderController::class, 'store'])->name('founders.store');
        Route::delete('founders/{founder}', [\App\Http\Controllers\FounderController::class, 'destroy'])->name('founders.destroy');

        Route::post('startups/{startup}/funding-rounds', [\App\Http\Controllers\FundingRoundController::class, 'store'])->name('funding-rounds.store');
        Route::delete('funding-rounds/{fundingRound}', [\App\Http\Controllers\FundingRoundController::class, 'destroy'])->name('funding-rounds.destroy');
    });

    Route::get('startups/{startup}', [\App\Http\Controllers\StartupController::class, 'show'])->name('startups.show');
});

require __DIR__.'/auth.php';
