<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;

class SuratController extends Controller
{
    public function index()
    {

        $JenisSurat = JenisSurat::all();

        return view('layouts.landing-page.layanan.surat', compact('JenisSurat'));
    }
}
