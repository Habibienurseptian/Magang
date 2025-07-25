<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use App\Models\Skill;

class LearningController extends Controller
{
    public function index()
    {
        $skill = request('skill', 'all');
        $search = request('search');
        $query = Learning::with('skill');
        if ($skill && $skill !== 'all') {
            $query->where('skill_id', $skill);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('skill', function($sq) use ($search) {
                      $sq->where('name', 'like', "%$search%") ;
                  })
                  ->orWhere('description', 'like', "%$search%") ;
            });
        }
        $query = $query
            ->join('skills', 'learnings.skill_id', '=', 'skills.id')
            ->orderBy('skills.name', 'asc')
            ->orderByRaw("FIELD(learnings.level, 'pemula', 'menengah', 'ahli')")
            ->select('learnings.*');
        $learnings = $query->paginate(8)->appends(request()->except('page'));
        $skills = Skill::orderBy('name', 'asc')->get();
        return view('users.learning.index', compact('learnings', 'skills'));
    }
    public function show($id)
    {
        $learning = \App\Models\Learning::findOrFail($id);
        return view('users.learning.show', compact('learning'));
    }
}
