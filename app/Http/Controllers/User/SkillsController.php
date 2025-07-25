<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsController extends Controller
{
    // Tampilkan form pilih bidang keahlian
    public function choose()
    {
        $skills = \App\Models\Skill::orderBy('name')->get();
        return view('Users.skills.choose', compact('skills'));
    }

    // Simpan bidang keahlian user
    public function save(Request $request)
    {
        $request->validate([
            'skill' => 'required|string|max:100',
            'level' => 'required|string|max:50',
        ]);
        $user = Auth::user();
        $user->skill = $request->skill;
        $user->skill_level = $request->level;
        $user->save();
        return redirect()->route('dashboard.users')->with('success', 'Bidang keahlian berhasil disimpan.');
    }
}
