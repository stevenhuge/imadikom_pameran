<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Activity;

class LandingController extends Controller
{
    public function index()
    {
        echo "[CTRL-1] Masuk ke LandingController...<br>";
        try {
            echo "[CTRL-2] Mengambil Setting DB...<br>";
            $active_year = \App\Models\Setting::get('active_board_year');
            if (!$active_year) {
                echo "[CTRL-3] Mengambil max year dari BoardMember...<br>";
                $active_year = \App\Models\BoardMember::max('year');
            }

            echo "[CTRL-4] Mengambil Department beserta relasi...<br>";
            $departments = Department::with(['boardMembers' => function($query) use ($active_year) {
                if ($active_year) {
                    $query->where('year', $active_year);
                }
            }])->get();

            echo "[CTRL-5] Mengambil Activities...<br>";
            $activities = Activity::all();
            
            echo "[CTRL-6] Semua data DB berhasil diambil!<br>";
        } catch (\Throwable $e) {
            echo "[CTRL-ERROR] Terjadi error DB: " . $e->getMessage() . "<br>";
            // Fallback jika tabel belum ada (migrasi belum dijalankan di server)
            $departments = collect();
            $activities = collect();
            $active_year = null;
        }

        echo "[CTRL-7] Mulai render View landing...<br>";
        $html = view('landing', compact('departments', 'activities', 'active_year'))->render();
        echo "[CTRL-8] View berhasil dirender!<br>";
        
        echo "<h2>JIKA ANDA MELIHAT INI, BERARTI CONTROLLER DAN DATABASE BERHASIL 100%!</h2>";
        exit;
        
        return $html;
    }
}
