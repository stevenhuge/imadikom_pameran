<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poster;
use App\Models\Vote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_voters' => User::count(),
            'total_posters' => Poster::count(),
            'total_votes' => Vote::count(),
            'total_bidikmisi' => Poster::where('is_bidikmisi', true)->count(),
        ];

        $leaderboard = Poster::withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(5)
            ->get();

        $voting_status = \App\Models\Setting::get('voting_status', 'open');
        $voting_deadline = \App\Models\Setting::get('voting_deadline');

        return view('admin.dashboard', compact('stats', 'leaderboard', 'voting_status', 'voting_deadline'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'voting_status' => 'required|in:open,closed',
            'voting_deadline' => 'nullable|date',
        ]);

        \App\Models\Setting::set('voting_status', $request->voting_status);
        \App\Models\Setting::set('voting_deadline', $request->voting_deadline);

        return back()->with('success', 'Pengaturan voting berhasil diperbarui!');
    }
}