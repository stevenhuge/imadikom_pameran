<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        $votes = Vote::with(['user', 'poster'])->latest()->paginate(20);
        return view('admin.votes.index', compact('votes'));
    }
}
