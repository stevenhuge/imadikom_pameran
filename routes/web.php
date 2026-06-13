<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PosterController;
use App\Http\Controllers\Admin\BidikmisiMemberController;
use App\Http\Controllers\Admin\VoteController as AdminVoteController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════
Route::middleware('throttle:global')->get('/', [HomeController::class, 'index'])->name('home');

// API ROUTES
Route::get('/api/check-nim/{nim}', [BidikmisiMemberController::class, 'checkNim'])->name('api.check.nim');

// ═══════════════════════════════════════════
// AUTH ROUTES (Breeze)
// ═══════════════════════════════════════════
require __DIR__.'/auth.php';

// ═══════════════════════════════════════════
// VOTER ROUTES (Login Required)
// ═══════════════════════════════════════════
Route::middleware(['auth'])->group(function () {
    Route::middleware('throttle:voting')->post('/vote/{poster}', [VoteController::class, 'store'])->name('vote.store');
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    });
});

// ═══════════════════════════════════════════
// ADMIN ROUTES (Admin Only)
// ═══════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::resource('posters', PosterController::class);
    Route::post('members/import', [BidikmisiMemberController::class, 'import'])->name('members.import');
    Route::resource('members', BidikmisiMemberController::class)->except(['show']);
    Route::get('/votes', [AdminVoteController::class, 'index'])->name('votes.index');

    Route::middleware(['superadmin'])->group(function () {
        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->except(['show']);
    });
});