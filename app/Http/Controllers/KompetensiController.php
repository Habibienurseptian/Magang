<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KompetensiController extends Controller
{
    public function index()
    {
        return view('users.kompetensi.index');
    }
}
