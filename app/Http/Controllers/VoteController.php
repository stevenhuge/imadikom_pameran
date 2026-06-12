<?php
namespace App\Http\Controllers;

use App\Models\Poster;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Poster $poster)
    {
        $voting_status = \App\Models\Setting::get('voting_status', 'open');
        $voting_deadline = \App\Models\Setting::get('voting_deadline');
        $is_voting_open = $voting_status === 'open';
        if ($is_voting_open && $voting_deadline) {
            $is_voting_open = now()->lt(\Carbon\Carbon::parse($voting_deadline));
        }

        if (!$is_voting_open) {
            return back()->with('error', 'Maaf, periode voting telah ditutup.');
        }

        $user = auth()->user();

        // Cek apakah user sudah pernah vote (1 vote total)
        if ($user->hasVoted()) {
            $votedPoster = Vote::where('user_id', $user->id)->first()->poster;
            return back()->with('error',
                "Kamu sudah memberikan suara untuk \"{$votedPoster->judul}\". Setiap voter hanya boleh 1 kali vote!"
            );
        }

        Vote::create([
            'user_id'   => $user->id,
            'poster_id' => $poster->id,
        ]);

        return back()->with('success',
            "🎉 Yeay! Suaramu untuk \"{$poster->judul}\" berhasil dicatat!"
        );
    }
}