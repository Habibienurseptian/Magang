<?php

namespace App\Http\Controllers\instruktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use PDF;

class SertifikatController extends Controller
{
    public function index()
{
    $completedUsers = User::with(['competencyHistories' => function($q) {
            $q->whereNotNull('completed_at')
              ->latest()
              ->with('competency');
        }])
        ->get()
        ->filter(function($user) {
            $history = $user->competencyHistories->first();

            if (!$history || !$history->competency) {
                return false;
            }

            $isPassed = false;

            // Ambil skor dan hitung persentase
            if ($history->score && preg_match('/(\d+)\/(\d+)/', $history->score, $m)) {
                $benar = (int)$m[1];
                $total = (int)$m[2];
                if ($total > 0 && round($benar / $total * 100) >= $history->competency->passing_grade) {
                    $isPassed = true;
                }
            }

            return $isPassed;
        })
        ->map(function($user) {
            $history = $user->competencyHistories->first();
            $user->kompetensi_name = $history->competency->title ?? '-';
            $user->completed_at = $history->completed_at;

            // Ambil sertifikat jika ada
            $certificate = Certificate::where('user_id', $user->id)
                ->where('competency_id', $history->competency->id)
                ->first();

            $user->certificate_url = $certificate ? $certificate->certificate_url : null;

            return $user;
        })
        ->values();

    return view('instruktur.Sertifikat.index', compact('completedUsers'));
}


    // Generate sertifikat untuk user
    public function generate($userId)
    {
        $user = User::with(['competencyHistories' => function($q) {
            $q->whereNotNull('completed_at')->latest();
        }])->findOrFail($userId);

        $history = $user->competencyHistories->first();
        if (!$history) {
            return back()->with('error', 'User belum menyelesaikan uji kompetensi.');
        }

        // Generate PDF sertifikat
       $pdf = PDF::loadView('instruktur.Sertifikat.certificate', [
            'user' => $user,
            'kompetensi' => $history->competency,
            'completed_at' => $history->completed_at,
        ])->setPaper('A4', 'landscape');

        $filename = 'sertifikat_' . $user->id . '_' . time() . '.pdf';
        $path = 'certificates/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        // Simpan atau update record ke tabel certificates
        Certificate::updateOrCreate(
            [
                'user_id' => $user->id,
                'competency_id' => $history->competency->id ?? null,
            ],
            [
                'certificate_url' => Storage::url($path),
                'completed_at' => $history->completed_at,
            ]
        );

        return back()->with('success', 'Sertifikat berhasil diterbitkan!');
    }

    // Download sertifikat
    public function download($userId)
    {
        $user = User::with(['competencyHistories' => function($q) {
            $q->whereNotNull('completed_at')->latest();
        }])->findOrFail($userId);

        $history = $user->competencyHistories->first();
        if (!$history) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        $certificate = Certificate::where('user_id', $user->id)
            ->where('competency_id', optional($history->competency)->id)
            ->first();

        if (!$certificate || empty($certificate->certificate_url)) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        $file = str_replace('/storage/', '', $certificate->certificate_url);
        return Storage::disk('public')->download($file);
    }
}
