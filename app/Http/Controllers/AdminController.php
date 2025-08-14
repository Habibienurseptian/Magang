<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learning;
use App\Models\Competency;
use App\Models\UserCompetencyHistory;
use Illuminate\Validation\Rule;
use App\Models\Skill;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $data = [
            'learningCount' => Learning::count(),
            'kompetensiCount' => Competency::count(),
            'sertifikatCount' => UserCompetencyHistory::whereNotNull('completed_at')->count(),
            'tahunAkademik' => '2025/2026',
            'totalUser' => User::count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'bidangCount' => Skill::count(),
            'usersList' => User::latest()->take(10)->get()
        ];

        return view('admin.index', $data);
    }

    public function userList(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|digits_between:10,15',
            'role' => 'required|in:user,admin,instruktur',
        ];

        if ($request->role === 'user') {
            $rules['nik'] = ['required', 'digits:16', 'unique:users,nik'];
        }

        $validated = $request->validate($rules);

        $generatedPassword = \Str::random(8);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($generatedPassword),
            'role' => $validated['role'],
            'nik' => $validated['nik'] ?? null,
        ]);
        $user->save();

        // Normalisasi nomor HP -> format internasional 62
        $rawPhone = preg_replace('/[^0-9]/', '', $user->phone);
        if (substr($rawPhone, 0, 1) === '0') {
            $waNumber = '62' . substr($rawPhone, 1);
        } elseif (substr($rawPhone, 0, 2) === '62') {
            $waNumber = $rawPhone;
        } else {
            $waNumber = '62' . $rawPhone;
        }

        // Format pesan
        $message = "*Akun Anda berhasil dibuat!*\n\n"
            . "Email: {$user->email}\n"
            . "Password: {$generatedPassword}\n\n"
            . "Silakan login ke sistem dan segera ubah password Anda.";

        // Kirim pesan via Fonnte
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $waNumber,
            'message' => $message,
        ]);

        // Debug respon API
        $result = $response->json();
        if (!empty($result['status']) && $result['status'] === true) {
            return redirect()->route('admin.users.index')
                ->with('success', 'Akun berhasil dibuat dan password sudah dikirim via WhatsApp.');
        } else {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun berhasil dibuat, tapi gagal kirim pesan WA. Alasan: ' . ($result['reason'] ?? 'Tidak diketahui'));
        }
    }



    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|digits_between:10,15',
            'role' => 'required|in:user,admin,instruktur',
            'password' => 'nullable|string|min:8',
        ];

        // Validasi NIK
        if ($request->role === 'user') {
            $rules['nik'] = ['required', 'digits:16', Rule::unique('users')->ignore($user->id)];
        } else {
            $rules['nik'] = ['nullable', 'digits:16', Rule::unique('users')->ignore($user->id)];
        }

        $validated = $request->validate($rules);

        $user->update([
            'nik' => $validated['nik'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
            $user->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }


    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
