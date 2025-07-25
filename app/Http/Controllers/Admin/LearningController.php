<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;

class LearningController extends Controller
{
    public function edit($id)
    {
        $learning = Learning::findOrFail($id);
        $skills = \App\Models\Skill::orderBy('name')->get();
        return view('admin.learning.edit', compact('learning', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required',
            'description' => 'required',
            'image' => 'nullable|url',
        ]);
        $learning = Learning::findOrFail($id);
        $learning->update([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'description' => $request->description,
            'image' => $request->image ?? 'https://via.placeholder.com/400',
        ]);
        return redirect()->route('admin.learning.index')->with('success', 'Learning Path berhasil diupdate.');
    }
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
        $skills = \App\Models\Skill::orderBy('name')->get();
        return view('admin.learning.index', compact('learnings', 'skills'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required',
            'description' => 'required',
            'image' => 'nullable|url',
        ]);

        Learning::create([
            'title' => $request->title,
            'skill_id' => $request->skill_id,
            'level' => $request->level,
            'description' => $request->description,
            'image' => $request->image ?? 'https://via.placeholder.com/400', // default gambar
        ]);

        return redirect()->route('admin.learning.index')->with('success', 'Learning Path berhasil ditambahkan.');
    }

    public function show($id)
    {
        $learning = Learning::findOrFail($id);
        return view('admin.learning.show', compact('learning'));
    }

    public function destroy($id)
    {
        Learning::findOrFail($id)->delete();
        return redirect()->route('admin.learning.index')->with('success', 'Learning Path dihapus.');
    }
}
