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
            'total_competitions' => \App\Models\Competition::count(),
            'total_voters' => User::count(),
            'total_votes' => Vote::count(),
        ];

        $recent_competitions = \App\Models\Competition::latest()->take(5)->get();
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();

        return view('admin.dashboard', compact('stats', 'recent_competitions', 'admins'));
    }
}