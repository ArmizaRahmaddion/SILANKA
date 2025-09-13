<?php

namespace App\Http\Controllers\JenisSurat;

use App\Http\Controllers\Controller;

class SuratKeteranganAhliWarisController extends Controller
{
    public function create()
    {
        return view('layouts.landing-page.layanan.surat.skaw-form');
    }
}
