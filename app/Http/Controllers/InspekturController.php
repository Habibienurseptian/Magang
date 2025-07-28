<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InspekturController extends Controller
{
    /**
     * Tampilkan halaman dashboard inspektur.
     */
    public function index()
    {
        $learningCount = \App\Models\Learning::count();
        $kompetensiCount = \App\Models\Competency::count();
        $inspekturCount = \App\Models\User::where('role', 'inspektur')->count();
        $totalUser = \App\Models\User::count();
        $recentLearning = \App\Models\Learning::orderByDesc('created_at')->take(5)->get();
        $recentKompetensi = \App\Models\Competency::orderByDesc('created_at')->take(5)->get();
        $recentBidang = \App\Models\Skill::orderByDesc('created_at')->take(5)->get();
        $recentUsers = \App\Models\User::orderByDesc('created_at')->take(5)->get();
        return view('inspektur.index', compact('learningCount', 'kompetensiCount', 'inspekturCount', 'totalUser', 'recentLearning', 'recentKompetensi', 'recentBidang', 'recentUsers'));
    }
}
