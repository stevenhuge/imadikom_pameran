<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Poster;
use App\Models\Vote;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::latest()->get();
        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        return view('admin.competitions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'theme' => 'nullable|string|max:255',
            'fee_type' => 'required|in:free,paid',
            'eligibility_type' => 'required|in:1,2,3,4',
        ]);

        Competition::create($validated);

        return redirect()->route('admin.competitions.index')->with('success', 'Kompetisi berhasil ditambahkan.');
    }

    public function edit(Competition $competition)
    {
        return view('admin.competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'theme' => 'nullable|string|max:255',
            'fee_type' => 'required|in:free,paid',
            'eligibility_type' => 'required|in:1,2,3,4',
        ]);

        $competition->update($validated);

        return redirect()->route('admin.competitions.index')->with('success', 'Kompetisi berhasil diperbarui.');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();
        return redirect()->route('admin.competitions.index')->with('success', 'Kompetisi berhasil dihapus.');
    }

    public function setActive(Competition $competition)
    {
        // Deactivate all others
        Competition::query()->update(['is_active' => false]);
        // Activate this one
        $competition->update(['is_active' => true]);

        return back()->with('success', 'Kompetisi diaktifkan untuk publik.');
    }

    public function dashboard(Competition $competition)
    {
        $stats = [
            'total_posters' => $competition->posters()->count(),
            'total_votes' => $competition->votes()->count(),
            'total_bidikmisi' => $competition->posters()->where('is_bidikmisi', true)->count(),
        ];

        $leaderboard = $competition->posters()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.competitions.dashboard', compact('competition', 'stats', 'leaderboard'));
    }

    public function updateSettings(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'voting_status' => 'required|in:open,closed',
            'voting_deadline' => 'nullable|date',
            'registration_status' => 'required|in:open,closed',
            'registration_deadline' => 'nullable|date',
            'eligibility_type' => 'required|in:1,2,3,4',
        ]);

        $competition->update($validated);

        return back()->with('success', 'Pengaturan kompetisi berhasil disimpan.');
    }
}
