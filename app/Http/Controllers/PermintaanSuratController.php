<?php

namespace App\Http\Controllers;

use App\Models\PermintaanSurat;

class PermintaanSuratController extends Controller
{
    public function index()
    {
        $permintaanSurats = PermintaanSurat::with(['jenisSurat', 'verifikasiPengguna'])->latest()->get();

        return view('layouts.admin.permintaan-surat-list', compact('permintaanSurats'));
    }
}
