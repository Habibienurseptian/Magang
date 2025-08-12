<?php

namespace App\Http\Controllers\instruktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kompetensi;
use App\Models\Soal;

class KompetensiSoalController extends Controller
{
    // Tampilkan daftar soal untuk kompetensi tertentu
    public function index($kompetensiId)
    {
        $kompetensi = Kompetensi::findOrFail($kompetensiId);
        $soals = $kompetensi->soals()->latest()->get();
        return view('instruktur.kompetensi.soal.index', compact('kompetensi', 'soals'));
    }

    // Simpan soal baru
    public function store(Request $request, $kompetensiId)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer_key' => 'required|in:a,b,c,d',
        ]);
        $kompetensi = Kompetensi::findOrFail($kompetensiId);
        $kompetensi->soals()->create($request->only(['question','option_a','option_b','option_c','option_d','answer_key']));
        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    // Tampilkan form edit soal
    public function edit($kompetensiId, $soalId)
    {
        $kompetensi = Kompetensi::findOrFail($kompetensiId);
        $soal = $kompetensi->soals()->findOrFail($soalId);
        return view('instruktur.kompetensi.soal.edit', compact('kompetensi', 'soal'));
    }

    // Update soal
    public function update(Request $request, $kompetensiId, $soalId)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer_key' => 'required|in:a,b,c,d',
        ]);
        $kompetensi = Kompetensi::findOrFail($kompetensiId);
        $soal = $kompetensi->soals()->findOrFail($soalId);
        $soal->update($request->only(['question','option_a','option_b','option_c','option_d','answer_key']));
        return redirect()->route('instruktur.kompetensi.soal.index', $kompetensiId)->with('success', 'Soal berhasil diupdate.');
    }

    // Hapus soal
    public function destroy($kompetensiId, $soalId)
    {
        $kompetensi = Kompetensi::findOrFail($kompetensiId);
        $soal = $kompetensi->soals()->findOrFail($soalId);
        $soal->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}
