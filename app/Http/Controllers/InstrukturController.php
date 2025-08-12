<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstrukturController extends Controller
{
    /**
     * Tampilkan halaman dashboard instruktur.
     */
    public function index()
    {
        $learningCount = \App\Models\Learning::count();
        $kompetensiCount = \App\Models\Competency::count();
        $instrukturCount = \App\Models\User::where('role', 'instruktur')->count();
        $totalUser = \App\Models\User::count();
        $bidangCount = \App\Models\Skill::count();
        $recentLearning = \App\Models\Learning::orderByDesc('created_at')->take(5)->get();
        $recentKompetensi = \App\Models\Competency::orderByDesc('created_at')->take(5)->get();
        $recentBidang = \App\Models\Skill::orderByDesc('created_at')->take(5)->get();
        $recentUsers = \App\Models\User::orderByDesc('created_at')->take(5)->get();
        return view('instruktur.index', compact('learningCount', 'kompetensiCount', 'instrukturCount', 'totalUser', 'recentLearning', 'recentKompetensi', 'recentBidang', 'recentUsers', 'bidangCount'));
    }
}
