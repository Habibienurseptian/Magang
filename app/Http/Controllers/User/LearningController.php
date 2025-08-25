<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use App\Models\Competency;
use App\Models\Skill;
use App\Models\LearningStatus;
use App\Helpers\AesHelper;
use Illuminate\Http\Request;


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
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('skill', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%$search%");
                  })
                  ->orWhere('description', 'like', "%$search%");
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

    public function show($encId)
    {
        try {
            $id = AesHelper::decryptId($encId);
        } catch (\Throwable $e) {
            abort(404, 'ID tidak valid');
        }

        $learning = Learning::with('competency')->findOrFail($id);

        // cek status user
        $status = \App\Models\LearningStatus::where('user_id', auth()->id())
            ->where('learning_id', $learning->id)
            ->first();

        $hasWatched = $status && $status->status === 'menonton';

        return view('users.learning.show', [
            'learning'   => $learning,
            'encId'      => $encId,
            'hasWatched' => $hasWatched
        ]);
    }



    public function exam($encId)
    {
        try {
            $id = AesHelper::decryptId($encId);
        } catch (\Throwable $e) {
            abort(404, 'ID tidak valid');
        }

        $kompetensi = Competency::findOrFail($id);
        return view('users.kompetensi.show', compact('kompetensi'));
    }

    public function updateStatus(Request $request, $encId)
    {
        try {
            $id = AesHelper::decryptId($encId);
        } catch (\Throwable $e) {
            abort(404, 'ID tidak valid');
        }

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Harus login'], 401);
        }

        $learning = Learning::findOrFail($id);
        $status = $request->input('status', 'menonton');

        $record = LearningStatus::updateOrCreate(
            [
                'user_id' => $userId,
                'learning_id' => $learning->id
            ],
            [
                'status' => $status,
                'updated_at' => now()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil disimpan',
            'data' => $record
        ]);
    }


}