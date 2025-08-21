<?php

namespace App\Http\Controllers\instruktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competency;
use App\Models\Soal;


class SoalController extends Controller
{
    // Tampilkan daftar soal untuk competency tertentu
    public function index($competencyId)
    {
        $competency = Competency::findOrFail($competencyId);
        $soals = $competency->soals()->latest()->get();
        return view('instruktur.kompetensi.soal.index', compact('competency', 'soals'));
    }

    // Simpan soal baru
   public function store(Request $request, $competencyId)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer_key' => 'required|in:a,b,c,d',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['question','option_a','option_b','option_c','option_d','answer_key']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('soal_images', 'public');
        }

        $competency = Competency::findOrFail($competencyId);
        $competency->soals()->create($data);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }


    // Tampilkan form edit soal
    public function edit($competencyId, $soalId)
    {
        $competency = Competency::findOrFail($competencyId);
        $soal = $competency->soals()->findOrFail($soalId);
        return view('instruktur.kompetensi.soal.edit', compact('competency', 'soal'));
    }

    // Update soal
    public function update(Request $request, $competencyId, $soalId)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer_key' => 'required|in:a,b,c,d',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $competency = Competency::findOrFail($competencyId);
        $soal = $competency->soals()->findOrFail($soalId);

        $data = $request->only(['question','option_a','option_b','option_c','option_d','answer_key']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('soal_images', 'public');
        }

        $soal->update($data);

        return redirect()->route('instruktur.kompetensi.soal.index', $competencyId)
                        ->with('success', 'Soal berhasil diupdate.');
    }


    // Hapus soal
    public function destroy($competencyId, $soalId)
    {
        $competency = Competency::findOrFail($competencyId);
        $soal = $competency->soals()->findOrFail($soalId);
        $soal->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}
