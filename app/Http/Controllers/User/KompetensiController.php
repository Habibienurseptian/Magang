<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competency;

class KompetensiController extends Controller
{
    // Tampilkan daftar uji kompetensi untuk user
    public function index(Request $request)
    {
        $skill_id = $request->query('skill_id');
        $search = $request->query('search');
        $query = Competency::with('skill')
            ->join('skills', 'competencies.skill_id', '=', 'skills.id')
            ->orderBy('skills.name', 'asc')
            ->orderByRaw("FIELD(competencies.level, 'pemula', 'menengah', 'ahli')")
            ->orderBy('competencies.id', 'asc')
            ->select('competencies.*');
        if ($skill_id && $skill_id !== 'all' && is_numeric($skill_id)) {
            $query->where('skill_id', $skill_id);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('skill', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%") ;
                  })
                  ->orWhere('description', 'like', "%$search%") ;
            });
        }
        $kompetensis = $query->paginate(6)->appends($request->except('page'));
        $skills = \App\Models\Skill::orderBy('name', 'asc')->get();
        $userId = auth()->id();
        $isPassedArr = [];
        $scoreArr = [];
        foreach ($kompetensis as $kompetensi) {
            $history = \App\Models\UserCompetencyHistory::where('user_id', $userId)
                ->where('competency_id', $kompetensi->id)
                ->latest('completed_at')->first();
            $isPassed = false;
            $score = null;
            if ($history && $history->score) {
                $score = $history->score;
                if (preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                    $benar = (int)$m[1];
                    $total = (int)$m[2];
                    if ($total > 0 && round($benar/$total*100) >= $kompetensi->passing_grade) {
                        $isPassed = true;
                    }
                }
            }
            $isPassedArr[$kompetensi->id] = $isPassed;
            $scoreArr[$kompetensi->id] = $score;
        }
        return view('Users.Kompetensi.index', compact('kompetensis', 'skill_id', 'skills', 'isPassedArr', 'scoreArr'));
    }

    // Tampilkan detail uji kompetensi (opsional, jika ingin ada detail atau mulai uji)
    public function show($id)
    {
        $kompetensi = Competency::findOrFail($id);
        $userId = auth()->id();
        $history = \App\Models\UserCompetencyHistory::where('user_id', $userId)
            ->where('competency_id', $kompetensi->id)
            ->first();
        $isPassed = false;
        if ($history && $history->score) {
            if (preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                $benar = (int)$m[1];
                $total = (int)$m[2];
                if ($total > 0 && round($benar/$total*100) >= $kompetensi->passing_grade) {
                    $isPassed = true;
                }
            }
        }
        if ($isPassed) {
            return redirect()->route('users.kompetensi.index')->with('error', 'Anda sudah lulus uji kompetensi ini dan tidak dapat mengaksesnya lagi.');
        }
        return view('Users.Kompetensi.show', compact('kompetensi', 'isPassed'));
    }

    // Halaman mulai ujian kompetensi
    public function exam($id)
    {
        $kompetensi = Competency::findOrFail($id);
        $userId = auth()->id();
        $history = \App\Models\UserCompetencyHistory::where('user_id', $userId)
            ->where('competency_id', $kompetensi->id)
            ->first();
        $isPassed = false;
        if ($history && $history->score) {
            if (preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                $benar = (int)$m[1];
                $total = (int)$m[2];
                if ($total > 0 && round($benar/$total*100) >= $kompetensi->passing_grade) {
                    $isPassed = true;
                }
            }
        }
        if ($isPassed) {
            return redirect()->route('users.kompetensi.index')->with('error', 'Anda sudah lulus uji kompetensi ini dan tidak dapat mengaksesnya lagi.');
        }
        // Ambil soal terkait kompetensi
        $soals = $kompetensi->soals()->inRandomOrder()->get();
        if ($soals->count() == 0) {
            return redirect()->back()->with('error', 'Ujian tidak dapat dibuka karena belum ada soal.');
        }
        return view('Users.Kompetensi.exam', compact('kompetensi', 'soals'));
    }
    // Proses submit jawaban ujian kompetensi
    public function submitExam($id, \Illuminate\Http\Request $request)
    {
        $kompetensi = Competency::findOrFail($id);
        $soals = $kompetensi->soals;
        $answers = $request->input('answers', []);
        $score = 0;
        $total = $soals->count();
        foreach ($soals as $soal) {
            if (isset($answers[$soal->id]) && strtolower($answers[$soal->id]) == strtolower($soal->answer_key)) {
                $score++;
            }
        }
        // Simpan ke riwayat kompetensi user
        $scoreString = $score . '/' . $total;
        \App\Models\UserCompetencyHistory::create([
            'user_id' => auth()->id(),
            'competency_id' => $kompetensi->id,
            'score' => $scoreString,
            'completed_at' => now(),
        ]);
        return view('Users.Kompetensi.result', compact('kompetensi', 'score', 'total'));
    }
}
