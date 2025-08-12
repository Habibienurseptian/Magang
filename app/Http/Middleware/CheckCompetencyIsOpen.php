<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Competency;

class CheckCompetencyIsOpen
{
    public function handle(Request $request, Closure $next)
    {
        $competencyId = $request->route('id'); // ambil id kompetensi dari route param
        $competency = Competency::find($competencyId);

        if (!$competency) {
            abort(404, 'Uji Kompetensi tidak ditemukan.');
        }

        if (!$competency->is_available) { // misal ada kolom is_available yang di-toggle inspektur
            return redirect()->route('users.kompetensi.index')->with('error', 'Uji Kompetensi belum dibuka oleh inspektur.');
        }

        return $next($request);
    }
}
