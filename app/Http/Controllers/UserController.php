<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\Competency;
use App\Models\UserCompetencyHistory;
use App\Models\Learning;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Dashboard untuk user biasa
     */
    public function userDashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            abort(403, 'Akses ditolak.');
        }

        // Cek kolom is_available
        $competencyTable = (new Competency)->getTable();
        $hasIsAvailable = \Schema::hasColumn($competencyTable, 'is_available');
        $ujiKompetensiAktif = $hasIsAvailable
            ? Competency::where('is_available', true)->count()
            : Competency::count();

        // Cek skill_id user
        $skillId = null;
        if ($user->skill) {
            $skillModel = Skill::where('name', $user->skill)->first();
            if ($skillModel) $skillId = $skillModel->id;
        }

        // Hitung total kompetensi sesuai skill dan level
        $kompetensiQuery = Competency::query();
        if ($hasIsAvailable) $kompetensiQuery->where('is_available', true);
        if ($skillId) $kompetensiQuery->where('skill_id', $skillId);
        if ($user->skill_level) $kompetensiQuery->where('level', $user->skill_level);
        $kompetensi_total = $kompetensiQuery->count();

        $info = [
            'tahun_akademik' => '2025/2026',
            'total_peserta' => User::where('role', 'user')->count(),
            'total_user' => User::count(),
            'learning_path' => Learning::count(),
            'uji_kompetensi' => Competency::count(),
            'sertifikat_diterbitkan' => 3,
            'kompetensi_total' => $kompetensi_total,
            'bidang_keahlian' => Skill::count(),
        ];

        $recentActivities = [];
        $taskHistory = [];

        $histories = UserCompetencyHistory::with('competency')->where('user_id', $user->id)->latest()->get();
        foreach ($histories as $history) {
            $isPassed = false;
            if ($history->score && preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                $benar = (int) $m[1];
                $total = (int) $m[2];
                $isPassed = $total > 0 && round($benar / $total * 100) >= 70;
            }

            $lulusBadge = $isPassed ? ' <span class="badge bg-success ms-2">Lulus</span>' : '';
            $iconColor = $isPassed ? 'text-success' : 'text-warning';
            $skillName = $history->competency->skill->name ?? '-';
            $levelName = strtolower($history->competency->level ?? '-');
            $levelClass = match ($levelName) {
                'pemula' => 'bg-info text-dark',
                'menengah' => 'bg-warning text-dark',
                'ahli' => 'bg-primary',
                default => 'bg-secondary',
            };

            $recentActivities[] = '<i class="fas fa-clipboard-check ' . $iconColor . ' me-2"></i> Uji Kompetensi <b>' . e($history->competency->title) . '</b> <span class="badge bg-light text-dark ms-1">' . e($skillName) . '</span> <span class="badge ' . $levelClass . ' ms-1">' . e(ucfirst($levelName)) . '</span> telah selesai. Skor: <b>' . $history->score . '</b>' . $lulusBadge;

            $completedAt = Carbon::parse($history->completed_at);
            $taskHistory[] = '<i class="fas fa-tasks text-success me-2"></i> Uji Kompetensi <b>' . e($history->competency->title) . '</b> selesai pada <b>' . $completedAt->format('d M Y H:i') . '</b>';
        }

        $recentUsers = User::orderByDesc('created_at')->take(5)->get();

        return view('users.index', compact('user', 'recentActivities', 'taskHistory', 'info', 'recentUsers'));
    }
}
