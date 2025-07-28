<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $learningCount = \App\Models\Learning::count();
        $kompetensiCount = \App\Models\Competency::count();
        // Sertifikat: asumsikan jumlah user yang punya kompetensi selesai (dummy, sesuaikan jika ada model khusus)
        $sertifikatCount = \App\Models\UserCompetencyHistory::whereNotNull('completed_at')->count();
        $tahunAkademik = '2025/2026';
        $totalUser = \App\Models\User::count();
        $totalAdmin = \App\Models\User::where('role', 'admin')->count();

        $usersList = \App\Models\User::orderByDesc('created_at')->limit(10)->get();
        return view('admin.index', compact('learningCount', 'kompetensiCount', 'sertifikatCount', 'tahunAkademik', 'totalUser', 'totalAdmin', 'usersList'));
    }
}
