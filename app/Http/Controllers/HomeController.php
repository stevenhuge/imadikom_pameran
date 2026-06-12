<?php
namespace App\Http\Controllers;

use App\Models\Poster;

class HomeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Poster::withCount('votes');

        if ($search = $request->query('search')) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('pembuat', 'like', "%{$search}%");
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

        $topPosters = Poster::withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(3)
            ->get();

        $voting_status = \App\Models\Setting::get('voting_status', 'open');
        $voting_deadline = \App\Models\Setting::get('voting_deadline');
        
        $is_voting_open = $voting_status === 'open';
        if ($is_voting_open && $voting_deadline) {
            $is_voting_open = now()->lt(\Carbon\Carbon::parse($voting_deadline));
        }

        $userVotedPosterId = auth()->check()
            ? optional(auth()->user()->votes()->first())->poster_id
            : null;

        return view('home', compact('posters', 'topPosters', 'is_voting_open', 'voting_deadline', 'userVotedPosterId'));
    }
}