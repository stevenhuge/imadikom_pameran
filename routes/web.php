<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PosterController;
use App\Http\Controllers\Admin\BidikmisiMemberController;
use App\Http\Controllers\Admin\VoteController as AdminVoteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

// ═══════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════
Route::middleware('throttle:global')->get('/', [LandingController::class, 'index'])->name('landing');
Route::middleware('throttle:global')->get('/pameran', [HomeController::class, 'index'])->name('home');

// API ROUTES
Route::get('/api/check-nim/{nim}', [BidikmisiMemberController::class, 'checkNim'])->name('api.check.nim');

// VERCEL MIGRATION FIX
Route::get('/vercel-migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AdminSeeder', '--force' => true]);
    return 'Migrations and Seeder run successfully on Vercel! <a href="/login">Go to Login</a>';
});

// ═══════════════════════════════════════════
// AUTH ROUTES (Breeze)
// ═══════════════════════════════════════════
require __DIR__.'/auth.php';

// ═══════════════════════════════════════════
// VOTER ROUTES (Login Required)
// ═══════════════════════════════════════════
Route::middleware(['auth'])->group(function () {
    Route::middleware('throttle:voting')->post('/vote/{poster}', [VoteController::class, 'store'])->name('vote.store');
    
    Route::get('/participant/dashboard', [\App\Http\Controllers\ParticipantController::class, 'dashboard'])->name('participant.dashboard');
    Route::post('/participant/upload/{competition}', [\App\Http\Controllers\ParticipantController::class, 'storeKarya'])->name('participant.store_karya');

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'participant') {
            return redirect()->route('participant.dashboard');
        }
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
    Route::post('posters/{poster}/toggle-visibility', [PosterController::class, 'toggleVisibility'])->name('posters.toggle-visibility');
    Route::post('members/import', [BidikmisiMemberController::class, 'import'])->name('members.import');
    Route::resource('members', BidikmisiMemberController::class)->except(['show']);
    Route::get('/votes', [AdminVoteController::class, 'index'])->name('votes.index');

    Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class)->except(['show']);
    Route::resource('board-members', \App\Http\Controllers\Admin\BoardMemberController::class);
    Route::post('board-members/set-active-year', [\App\Http\Controllers\Admin\BoardMemberController::class, 'setActiveYear'])->name('board-members.set-active-year');
    Route::resource('activities', \App\Http\Controllers\Admin\ActivityController::class)->except(['show']);
    Route::resource('competitions', \App\Http\Controllers\Admin\CompetitionController::class)->except(['show']);
    Route::post('competitions/{competition}/set-active', [\App\Http\Controllers\Admin\CompetitionController::class, 'setActive'])->name('competitions.set-active');
    Route::get('competitions/{competition}/dashboard', [\App\Http\Controllers\Admin\CompetitionController::class, 'dashboard'])->name('competitions.dashboard');
    Route::post('competitions/{competition}/settings', [\App\Http\Controllers\Admin\CompetitionController::class, 'updateSettings'])->name('competitions.settings');

    Route::middleware(['superadmin'])->group(function () {
        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->except(['show']);
    });
});