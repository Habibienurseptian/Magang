<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competency;
use App\Models\Learning;
use App\MOdels\UserCompetencyHistory;
use App\Helpers\AesHelper;

class KompetensiController extends Controller
{
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

    public function show($encId, $learningId = null)
    {

        try {
            $id = AesHelper::decryptId($encId, 'kompetensi');
        } catch (\Throwable $e) {
            abort(404, 'ID ujian tidak valid');
        }

        $kompetensi = Competency::with('learnings')->findOrFail($id);

        // Cari learning yang sesuai
        if ($learningId) {
            $learning = $kompetensi->learnings->where('id', $learningId)->first();
        } else {
            $learning = $kompetensi->learnings->first();
        }

        $userId = auth()->id();
        $history = UserCompetencyHistory::where('user_id', $userId)
                ->where('competency_id', $kompetensi->id)
                ->latest('completed_at')
                ->first();

        $isPassed = false;
        if ($history && $history->score) {
            if (preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                $benar = (int)$m[1];
                $total = (int)$m[2];
                if ($total > 0 && round($benar / $total * 100) >= $kompetensi->passing_grade) {
                    $isPassed = true;
                }
            }
        }

        return view('Users.Kompetensi.show', compact('kompetensi', 'isPassed', 'learning'));
    }


    public function exam($encId)
    {
        try {
            $id = AesHelper::decryptId($encId, 'kompetensi');
        } catch (\Throwable $e) {
            abort(404, 'ID ujian tidak valid');
        }

        $kompetensi = Competency::with('learnings')->findOrFail($id);

        // Hapus data ujian lama supaya selalu mulai baru
        session()->forget("exam_data_{$id}");

        // Cek kalau user sudah lulus
        $history = \App\Models\UserCompetencyHistory::where('user_id', auth()->id())
            ->where('competency_id', $kompetensi->id)
            ->latest('completed_at')
            ->first();

        if ($history && $history->score) {
            if (preg_match('/(\d+)\/(\d+)/', $history->score, $match)) {
                $benar = (int)$match[1];
                $total = (int)$match[2];
                if ($total > 0 && round($benar / $total * 100) >= $kompetensi->passing_grade) {
                    return redirect()->route('users.learning.index')
                        ->with('error', 'Anda sudah lulus uji kompetensi ini dan tidak dapat mengaksesnya lagi.');
                }
            }
        }

        // Ambil soal acak & simpan di session
        $soals = $kompetensi->soals()->inRandomOrder()->get();
        if ($soals->count() == 0) {
            return redirect()->back()->with('error', 'Ujian tidak dapat dibuka karena belum ada soal.');
        }

        session()->put("exam_data_{$id}", [
            'started_at' => now(),
            'soals' => $soals->pluck('id')->toArray()
        ]);

        return view('Users.Kompetensi.exam', compact('kompetensi', 'soals'));
    }


    public function submitExam($encId, \Illuminate\Http\Request $request, $learningId = null)
    {

        try {
            $id = AesHelper::decryptId($encId, 'kompetensi');
        } catch (\Throwable $e) {
            abort(404, 'ID ujian tidak valid');
        }

        $kompetensi = Competency::with('learnings')->findOrFail($id);

        // Proteksi: kalau sudah lulus, stop
        $history = \App\Models\UserCompetencyHistory::where('user_id', auth()->id())
            ->where('competency_id', $kompetensi->id)
            ->latest('completed_at')
            ->first();

        if ($history && $history->score) {
            if (preg_match('/(\d+)\/(\d+)/', $history->score, $match)) {
                $benar = (int)$match[1];
                $total = (int)$match[2];
                if ($total > 0 && round($benar / $total * 100) >= $kompetensi->passing_grade) {
                    return redirect()->route('users.learning.index')
                        ->with('error', 'Anda sudah lulus uji kompetensi ini dan tidak dapat mengaksesnya lagi.');
                }
            }
        }

        // Ambil learning yang benar
        if ($learningId) {
            $learning = $kompetensi->learnings->where('id', $learningId)->first();
        } else {
            $learning = $kompetensi->learnings->first();
        }

        if (!$learning) {
            return redirect()->route('users.learning.index')
                ->with('error', 'Learning tidak ditemukan untuk kompetensi ini.');
        }

        // Hitung nilai
        $soals = $kompetensi->soals;
        if ($soals->count() == 0) {
            return redirect()->back()->with('error', 'Tidak ada soal untuk kompetensi ini.');
        }

        $answers = $request->input('answers', []);
        $score = 0;
        $total = $soals->count();

        foreach ($soals as $soal) {
            if (isset($answers[$soal->id]) && strtolower($answers[$soal->id]) == strtolower($soal->answer_key)) {
                $score++;
            }
        }

        $scoreString = $score . '/' . $total;

        \App\Models\UserCompetencyHistory::create([
            'user_id' => auth()->id(),
            'competency_id' => $kompetensi->id,
            'score' => $scoreString,
            'completed_at' => now(),
        ]);

        return view('Users.Kompetensi.result', compact('kompetensi', 'score', 'total', 'learning'));
    }
}