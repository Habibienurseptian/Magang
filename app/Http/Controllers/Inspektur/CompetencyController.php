<?php

namespace App\Http\Controllers\Inspektur;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{

    public function edit($id)
    {
        $kompetensi = Competency::findOrFail($id);
        $skills = \App\Models\Skill::orderBy('name')->get();
        return view('inspektur.kompetensi.edit', compact('kompetensi', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|string',
            'duration' => 'required|integer|min:1',
            'description' => 'required|string',
        ]);
        $kompetensi = Competency::findOrFail($id);
        $kompetensi->update([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'duration' => $request->duration,
            'description' => $request->description,
        ]);
        return redirect()->route('inspektur.kompetensi.index')->with('success', 'Uji Kompetensi berhasil diupdate!');
    }
    public function index(Request $request)
    {
        $query = Competency::with('skill');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhereHas('skill', function($q2) use ($q) {
                        $q2->where('name', 'like', "%$q%") ;
                    })
                    ->orWhere('description', 'like', "%$q%") ;
            });
        }
        $competencies = $query->paginate(10);
        $skills = \App\Models\Skill::orderBy('name')->get();
        return view('inspektur.kompetensi.index', compact('competencies', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|string',
            'duration' => 'required|integer|min:1',
            'description' => 'required|string',
        ]);

        Competency::create([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'duration' => $request->duration,
            'description' => $request->description,
            'is_available' => false, // Default: belum tersedia
        ]);

        return redirect()->route('inspektur.kompetensi.index')->with('success', 'Uji Kompetensi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $competency = Competency::findOrFail($id);
        $competency->delete();

        return redirect()->route('inspektur.kompetensi.index')->with('success', 'Uji Kompetensi berhasil dihapus!');
    }

    public function toggle($id)
    {
        $competency = Competency::findOrFail($id);
        $competency->is_available = !$competency->is_available;
        $competency->save();
        return redirect()->route('inspektur.kompetensi.index')->with('success', 'Status uji kompetensi berhasil diubah.');
    }
}
