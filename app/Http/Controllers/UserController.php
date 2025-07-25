<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Dashboard untuk user biasa
     */
    public function userDashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            abort(403, 'Akses ditolak.');
        }

        // Recent activities: uji kompetensi selesai
        $recentActivities = [];
        $taskHistory = [];
        // Cek apakah kolom 'status' ada di tabel competencies

        // Cek kolom is_available
        $competencyTable = (new \App\Models\Competency)->getTable();
        $hasIsAvailable = \Schema::hasColumn($competencyTable, 'is_available');
        $ujiKompetensiAktif = $hasIsAvailable
            ? \App\Models\Competency::where('is_available', true)->count()
            : \App\Models\Competency::count();



        // Cari skill_id dari nama skill user (jika user->skill berupa string)
        $skillId = null;
        if ($user->skill) {
            $skillModel = \App\Models\Skill::where('name', $user->skill)->first();
            if ($skillModel) {
                $skillId = $skillModel->id;
            }
        }

        // Filter kompetensi sesuai bidang (skill_id) dan level user
        $kompetensiQuery = \App\Models\Competency::query();
        if ($hasIsAvailable) {
            $kompetensiQuery->where('is_available', true);
        }
        if ($skillId) {
            $kompetensiQuery->where('skill_id', $skillId);
        }
        if ($user->skill_level) {
            $kompetensiQuery->where('level', $user->skill_level);
        }
        $kompetensi_total = $kompetensiQuery->count();

        // Hitung jumlah uji kompetensi yang sudah diselesaikan user (lulus, per bidang & level unik)
        $kompetensi_selesai = \App\Models\UserCompetencyHistory::where('user_id', $user->id)
            ->whereHas('competency', function($q) use ($hasIsAvailable, $skillId, $user) {
                if ($hasIsAvailable) $q->where('is_available', true);
                if ($skillId) $q->where('skill_id', $skillId);
                if ($user->skill_level) $q->where('level', $user->skill_level);
            })
            ->get()
            ->filter(function($history) {
                if ($history->score && preg_match('/(\d+)[\/](\d+)/', $history->score, $m)) {
                    $benar = (int)$m[1];
                    $total = (int)$m[2];
                    return $total > 0 && round($benar/$total*100) >= 70;
                }
                return false;
            })
            ->unique('competency_id')
            ->count();

        $progress_kompetensi = $kompetensi_total > 0 ? round($kompetensi_selesai / $kompetensi_total * 100) : 0;

        $info = [
            'tahun_akademik' => '2025/2026',
            'total_peserta' => \App\Models\User::where('role', 'user')->count(),
            'learning_path_aktif' => \App\Models\Learning::count(),
            'uji_kompetensi_aktif' => $ujiKompetensiAktif,
            'sertifikat_diterbitkan' => 3, // Dummy, sesuaikan jika ada model
            'kompetensi_total' => $kompetensi_total,
            'kompetensi_selesai' => $kompetensi_selesai,
            'progress_kompetensi' => $progress_kompetensi
        ];

        // Ambil riwayat uji kompetensi user
        $histories = \App\Models\UserCompetencyHistory::with('competency')->where('user_id', $user->id)->latest()->get();
        foreach ($histories as $history) {
            $isPassed = false;
            if ($history->score && preg_match('/(\d+)[\/](\d+)/', $history->score, $m)) {
                $benar = (int)$m[1];
                $total = (int)$m[2];
                if ($total > 0 && round($benar/$total*100) >= 70) {
                    $isPassed = true;
                }
            }
            $lulusBadge = $isPassed ? ' <span class="badge bg-success ms-2">Lulus</span>' : '';
            $iconColor = $isPassed ? 'text-success' : 'text-warning';
            $skillName = $history->competency->skill->name ?? '-';
            $levelName = strtolower($history->competency->level ?? '-');
            $levelClass = 'bg-secondary';
            if ($levelName == 'pemula') $levelClass = 'bg-info text-dark';
            elseif ($levelName == 'menengah') $levelClass = 'bg-warning text-dark';
            elseif ($levelName == 'ahli') $levelClass = 'bg-primary';
            $recentActivities[] = '<i class="fas fa-clipboard-check ' . $iconColor . ' me-2"></i> Uji Kompetensi <b>' . e($history->competency->title) . '</b> <span class="badge bg-light text-dark ms-1">' . e($skillName) . '</span> <span class="badge ' . $levelClass . ' ms-1">' . e(ucfirst($levelName)) . '</span> telah selesai. Skor: <b>' . $history->score . '</b>' . $lulusBadge;
            $completedAt = \Carbon\Carbon::parse($history->completed_at);
            $taskHistory[] = '<i class="fas fa-tasks text-success me-2"></i> Uji Kompetensi <b>' . e($history->competency->title) . '</b> selesai pada <b>' . $completedAt->format('d M Y H:i') . '</b>';
        }
        return view('users.index', compact('user', 'recentActivities', 'taskHistory', 'info'));
    }

    /**
     * Menampilkan daftar user (halaman manajemen pengguna) untuk admin
     */
    public function userList()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Simpan user baru oleh admin
     */
    public function store(Request $request)
    {
        // Validasi input


        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:users,nik'],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:6',
        ]);

        // Buat user baru (nik disimpan sebagai string agar tidak hilang angka depan)
        User::create([
            'nik' => (string) $validated['nik'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:users,nik,' . $user->id],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:6', // boleh kosong
        ]);

        $user->nik = (string) $validated['nik'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    
}
