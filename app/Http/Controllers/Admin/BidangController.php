<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class BidangController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('name')->get();
        return view('Admin.Bidang.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:skills,name',
        ]);
        Skill::create(['name' => $request->name]);
        return redirect()->route('admin.bidang.index')->with('success', 'Bidang keahlian berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return redirect()->route('admin.bidang.index')->with('success', 'Bidang keahlian berhasil dihapus.');
    }
}
