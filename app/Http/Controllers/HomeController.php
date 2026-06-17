<?php
namespace App\Http\Controllers;

use App\Models\Poster;

class HomeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $activeCompetition = \App\Models\Competition::where('is_active', true)->first();

        if (!$activeCompetition) {
            return view('home', [
                'posters' => collect(),
                'topPosters' => collect(),
                'is_voting_open' => false,
                'voting_deadline' => null,
                'userVotedPosterId' => null,
                'competition' => null
            ]);
        }

        $query = Poster::where('competition_id', $activeCompetition->id)
            ->where('is_visible', true)
            ->withCount('votes');

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pembuat', 'like', "%{$search}%");
            });
        }

        $sort = $request->query('sort', 'most_votes');
        if ($sort === 'newest') {
            $query->latest();
        } elseif ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->orderBy('votes_count', 'desc');
        }

        $posters = $query->get();

        $topPosters = Poster::where('competition_id', $activeCompetition->id)
            ->where('is_visible', true)
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(3)
            ->get();

        $voting_status = $activeCompetition->voting_status;
        $voting_deadline = $activeCompetition->voting_deadline;
        
        $is_voting_open = $voting_status === 'open';
        if ($is_voting_open && $voting_deadline) {
            $is_voting_open = now()->lt(\Carbon\Carbon::parse($voting_deadline));
        }

        $userVotedPosterId = auth()->check()
            ? optional(auth()->user()->votes()->where('competition_id', $activeCompetition->id)->first())->poster_id
            : null;
            
        $competition = $activeCompetition;

        return view('home', compact('posters', 'topPosters', 'is_voting_open', 'voting_deadline', 'userVotedPosterId', 'competition'));
    }
}