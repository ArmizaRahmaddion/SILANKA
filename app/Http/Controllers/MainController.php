<?php

namespace App\Http\Controllers;

use App\Models\PerangkatNagari;

class MainController extends Controller
{
    public function perangkat()
    {
        $perangkat = PerangkatNagari::all();

        return view('layouts.landing-page.profil.perangkat', compact('perangkat'));
    }

    public function berita()
    {
        return view('layouts.landing-page.berita.lamanberita');
    }

    // public function surat()
    // {
    //     return view('frontend.layanan.surat');
    // }
    // public function pengaduan()
    // {
    //     return view('frontend.layanan.pengaduan');
    // }
}
