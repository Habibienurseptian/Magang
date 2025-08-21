<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file     = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs('ckeditor', $filename, 'public');

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url'      => asset('storage/' . $path),
            ]);
        }

        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Tidak ada file diupload']], 400);
    }
}
