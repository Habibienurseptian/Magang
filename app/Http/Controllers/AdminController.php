<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learning;
use App\Models\Competency;
use App\Models\UserCompetencyHistory;
use Illuminate\Validation\Rule;

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
            'role' => 'required|in:user,admin,inspektur',
            'password' => 'required|string|min:6',
        ];

        if ($request->role === 'user') {
            $rules['nik'] = ['required', 'digits:16', 'unique:users,nik'];
        }

        $validated = $request->validate($rules);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'nik' => $validated['nik'] ?? null,
        ]);

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
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
            'role' => 'required|in:user,admin,inspektur',
            'password' => 'nullable|string|min:6',
        ];

        // Validasi NIK kondisional
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


    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
