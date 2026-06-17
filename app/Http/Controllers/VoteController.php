<?php
namespace App\Http\Controllers;

use App\Models\Poster;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Poster $poster)
    {
        $competition = $poster->competition;

        if (!$competition || !$competition->is_active) {
            return back()->with('error', 'Maaf, kompetisi ini tidak sedang aktif.');
        }

        $voting_status = $competition->voting_status;
        $voting_deadline = $competition->voting_deadline;
        $is_voting_open = $voting_status === 'open';
        
        if ($is_voting_open && $voting_deadline) {
            $is_voting_open = now()->lt(\Carbon\Carbon::parse($voting_deadline));
        }

        if (!$is_voting_open) {
            return back()->with('error', 'Maaf, periode voting untuk kompetisi ini telah ditutup.');
        }

        $user = auth()->user();

        // Cek apakah user sudah pernah vote di kompetisi ini
        $existingVote = Vote::where('user_id', $user->id)
                            ->where('competition_id', $competition->id)
                            ->first();

        if ($existingVote) {
            $votedPoster = $existingVote->poster;
            return back()->with('error',
                "Kamu sudah memberikan suara untuk \"{$votedPoster->judul}\" pada kompetisi ini. Setiap voter hanya boleh 1 kali vote per kompetisi!"
            );
        }

        Vote::create([
            'user_id'   => $user->id,
            'poster_id' => $poster->id,
            'competition_id' => $competition->id,
        ]);

        return back()->with('success',
            "🎉 Yeay! Suaramu untuk \"{$poster->judul}\" berhasil dicatat!"
        );
    }
}