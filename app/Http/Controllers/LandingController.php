<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Activity;

class LandingController extends Controller
{
    public function index()
    {
        try {
            $active_year = \App\Models\Setting::get('active_board_year');
            if (!$active_year) {
                $active_year = \App\Models\BoardMember::max('year');
            }

            // Hanya ambil department yang punya board member di tahun aktif, 
            // beserta relasinya khusus tahun tersebut.
            $departments = Department::with(['boardMembers' => function($query) use ($active_year) {
                if ($active_year) {
                    $query->where('year', $active_year);
                }
            }])->get();

            $activities = Activity::all();
        } catch (\Throwable $e) {
            // Fallback jika tabel belum ada (migrasi belum dijalankan di server)
            $departments = collect();
            $activities = collect();
            $active_year = null;
        }

        return view('landing', compact('departments', 'activities', 'active_year'));
    }
}
