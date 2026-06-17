<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Vote::with(['user', 'poster']);
        
        if ($request->has('competition_id')) {
            $query->where('competition_id', $request->competition_id);
            $competition = \App\Models\Competition::find($request->competition_id);
        } else {
            $competition = null;
        }

        $votes = $query->latest()->paginate(20);
        $competitions = \App\Models\Competition::orderBy('year', 'desc')->get();

        return view('admin.votes.index', compact('votes', 'competition', 'competitions'));
    }
}
