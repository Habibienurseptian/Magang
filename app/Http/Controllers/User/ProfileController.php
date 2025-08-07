<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Tampilkan profil user
    public function index()
    {
        $user = Auth::user();
        return view('Users.profile.index', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();
        $skills = \App\Models\Skill::all();
        return view('Users.profile.edit', compact('user', 'skills'));
    }

    // Proses update profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|digits_between:10,15',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->skill = $request->skill;
        $user->skill_level = $request->skill_level;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('users.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
