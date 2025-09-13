<?php

namespace App\Http\Controllers;

use App\Models\PermintaanSurat;
use App\Models\RiwayatStatus;
use App\Models\VerifikasiPengguna;
use Illuminate\Support\Facades\Auth;

class RiwayatSuratController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data verifikasi_pengguna berdasarkan user_id
        $verifikasiPengguna = VerifikasiPengguna::where('user_id', $user->id)->first();

        if (! $verifikasiPengguna) {
            return redirect()->back()->with('error', 'Data verifikasi pengguna tidak ditemukan.');
        }

        // Ambil permintaan surat berdasarkan verifikasi_pengguna_id
        $riwayatSurat = PermintaanSurat::with([
            'jenisSurat',
            'suratTerbit',
            'verifikasiPengguna',
        ])
            ->where('verifikasi_pengguna_id', $verifikasiPengguna->id)
            ->orderBy('tanggal_permintaan', 'desc')
            ->paginate(10);

        return view('layouts.landing-page.riwayat.surat.index', compact('riwayatSurat'));
    }

    // public function getRiwayatStatus($id)
    // {
    //     $permintaanSurat = PermintaanSurat::with([
    //         'jenisSurat',
    //         'suratTerbit'
    //     ])->findOrFail($id);

    //     $riwayatStatus = RiwayatStatus::where('permintaan_surat_id', $id)
    //         ->orderBy('tanggal_proses', 'asc')
    //         ->get();

    //     // Jika belum ada riwayat status, buat default
    //     if ($riwayatStatus->isEmpty()) {
    //         $defaultStatus = $this->createDefaultRiwayatStatus($permintaanSurat);
    //         $riwayatStatus = collect($defaultStatus);
    //     }

    //     return response()->json([
    //         'permintaan_surat' => $permintaanSurat,
    //         'riwayat_status' => $riwayatStatus
    //     ]);
    // }

    // private function createDefaultRiwayatStatus($permintaanSurat)
    // {
    //     $bagianList = ['Tata Usaha', 'Sekretaris Nagari', 'Wali Nagari'];
    //     $riwayatStatus = [];

    //     foreach ($bagianList as $index => $bagian) {
    //         $status = 'Menunggu';

    //         // Set status berdasarkan bagian saat ini
    //         if ($permintaanSurat->bagian_saat_ini === $bagian) {
    //             $status = 'Sedang Diproses';
    //         } elseif ($index < array_search($permintaanSurat->bagian_saat_ini, $bagianList)) {
    //             $status = 'Selesai';
    //         }

    //         $riwayatStatus[] = [
    //             'bagian' => $bagian,
    //             'status' => $status,
    //             'tanggal_proses' => $status === 'Selesai' ? $permintaanSurat->tanggal_permintaan : null,
    //             'keterangan' => $this->getKeteranganStatus($status)
    //         ];
    //     }

    //     return $riwayatStatus;
    // }

    // private function getKeteranganStatus($status)
    // {
    //     switch ($status) {
    //         case 'Selesai':
    //             return 'Proses telah selesai';
    //         case 'Sedang Diproses':
    //             return 'Sedang dalam proses verifikasi';
    //         case 'Menunggu':
    //             return 'Menunggu proses sebelumnya selesai';
    //         default:
    //             return '';
    //     }
    // }

    // public function getDetailSurat($id)
    // {
    //     $permintaanSurat = PermintaanSurat::with('jenisSurat')->findOrFail($id);

    //     return response()->json([
    //         'detail_surat' => $permintaanSurat->detail_surat,
    //         'jenis_surat' => $permintaanSurat->jenisSurat->nama_surat
    //     ]);
    // }
}
