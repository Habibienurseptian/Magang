<?php

namespace App\Http\Controllers\instruktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use App\Models\Competency;
use Illuminate\Validation\Rule;

class LearningController extends Controller
{
    public function index()
    {
        $category = request('category', 'all');
        $search = request('search');
        $query = Learning::query();
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%") ;
            });
        }
        $learnings = $query->paginate(8);
        $usedCompetencies = Learning::pluck('competency_id')->toArray();
        $skills = \App\Models\Skill::orderBy('name')->get();
        $competencies = Competency::whereNotIn('id', $usedCompetencies)
                              ->orderBy('title')
                              ->get();
        return view('instruktur.learning.index', compact('learnings', 'skills', 'competencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'youtube_url' => 'nullable|url',
            'competency_id' => 'required|exists:competencies,id|unique:learnings,competency_id',
            'watch_limit_minutes' => 'nullable|integer|min:0'
        ], [
            'competency_id.unique' => 'Kompetensi ini sudah digunakan pada Learning lain.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('learnings', 'public');
        }

        Learning::create([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'description' => $request->description,
            'image' => $imagePath ? '/storage/' . $imagePath : 'https://via.placeholder.com/400',
            'youtube_url' => $request->youtube_url,
            'competency_id' => $request->competency_id,
            'watch_limit_minutes' => $request->watch_limit_minutes ?? 0,
        ]);

        return redirect()->route('instruktur.learning.index')->with('success', 'Learning Path berhasil ditambahkan.');
    }



    public function show($id)
    {
        $learning = Learning::findOrFail($id);
        return view('instruktur.learning.show', compact('learning'));
    }

    public function destroy($id)
    {
        Learning::findOrFail($id)->delete();
        return redirect()->route('instruktur.learning.index')->with('success', 'Learning Path dihapus.');
    }

    public function edit($id)
    {
        $learning = Learning::findOrFail($id);
        $skills = \App\Models\Skill::orderBy('name')->get();

        // Ambil competency_id yang dipakai learning lain (bukan learning ini)
        $usedCompetencies = Learning::where('id', '!=', $learning->id)
                                    ->pluck('competency_id')
                                    ->toArray();

        // Ambil semua kompetensi yang belum terpakai atau kompetensi milik learning ini
        $competencies = \App\Models\Competency::whereNotIn('id', $usedCompetencies)
                                            ->orderBy('title')
                                            ->get();

        return view('instruktur.learning.edit', compact('learning', 'skills', 'competencies'));
    }

   public function update(Request $request, $id)
    {
        $learning = Learning::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'youtube_url' => 'nullable|url',
            'competency_id' => [
                'required',
                'exists:competencies,id',
                Rule::unique('learnings', 'competency_id')->ignore($learning->id)
            ],
            'watch_limit_minutes' => 'nullable|integer|min:0',
        ], [
            'competency_id.unique' => 'Kompetensi ini sudah digunakan pada Learning lain.'
        ]);

        $imagePath = $learning->image;
        if ($request->hasFile('image')) {
            $imagePath = '/storage/' . $request->file('image')->store('learnings', 'public');
        }

        $learning->update([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'description' => $request->description,
            'image' => $imagePath,
            'youtube_url' => $request->youtube_url,
            'competency_id' => $request->competency_id,
            'watch_limit_minutes' => $request->watch_limit_minutes ?? 0,
        ]);

        return redirect()->route('instruktur.learning.index')->with('success', 'Learning Path berhasil diupdate.');
    }


}
