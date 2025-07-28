<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;

class SertifikatController extends Controller
{
    // Tampilkan daftar sertifikat user yang login
    public function index()
    {
        $user = Auth::user();

        // Ambil semua sertifikat milik user dengan relasi competency
        $certificates = Certificate::with('competency')
            ->where('user_id', $user->id)
            ->orderByDesc('completed_at')
            ->get();

        return view('users.sertifikat.index', compact('certificates'));
    }

    // Download sertifikat (opsional)
    public function download($id)
    {
        $certificate = Certificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (empty($certificate->certificate_url)) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia.');
        }

        // Redirect langsung ke URL sertifikat (atau bisa buat response download file)
        return redirect($certificate->certificate_url);
    }
}
