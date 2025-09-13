<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with(['verifikasi.user', 'kategori'])->latest()->get();

        return view('layouts.admin.layanan.e-aduan.pengaduan-list', compact('pengaduan'));
    }

    public function create()
    {
        $verifikasi = Auth::user()->verifikasi;

        if (! $verifikasi || $verifikasi->status !== 'verified') {
            return redirect()->back()->with('error', 'Anda harus terverifikasi untuk mengakses fitur pengaduan.');
        }

        $kategoris = KategoriPengaduan::all();

        return view('layouts.landing-page.layanan.pengaduan', compact('kategoris', 'verifikasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_pengaduan_id' => 'required|exists:kategori_pengaduan,id',
            'tanggal' => 'required|date',
            'pengaduan' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $verifikasi = Auth::user()->verifikasi;

        $path = $request->file('file') ? $request->file('file')->store('pengaduan', 'public') : null;

        Pengaduan::create([
            'verifikasi_pengguna_id' => $verifikasi->id,
            'kategori_pengaduan_id' => $request->kategori_pengaduan_id,
            'tanggal' => $request->tanggal,
            'pengaduan' => $request->pengaduan,
            'file' => $path,
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }
}
