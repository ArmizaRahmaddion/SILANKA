<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\VerifikasiPengguna;
use Illuminate\Support\Facades\Auth;

class RiwayatPengaduanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data verifikasi_pengguna berdasarkan user_id
        $verifikasiPengguna = VerifikasiPengguna::where('user_id', $user->id)->first();

        if (! $verifikasiPengguna) {
            return redirect()->back()->with('error', 'Data verifikasi pengguna tidak ditemukan.');
        }

        // Ambil pengaduan berdasarkan verifikasi_pengguna_id
        $riwayatPengaduan = Pengaduan::with([
            'kategori',
            'verifikasi',
        ])
            ->where('verifikasi_pengguna_id', $verifikasiPengguna->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('layouts.landing-page.riwayat.pengaduan.index', compact('riwayatPengaduan'));
    }

    public function getDetailPengaduan($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'verifikasi'])->findOrFail($id);

        return response()->json([
            'detail_pengaduan' => $pengaduan,
            'kategori' => $pengaduan->kategori->nama_kategori ?? 'Tidak ada kategori',
            'tanggal' => $pengaduan->tanggal,
            'pengaduan' => $pengaduan->pengaduan,
            'file' => $pengaduan->file
        ]);
    }
}
