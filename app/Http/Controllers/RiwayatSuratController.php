<?php

namespace App\Http\Controllers;

use App\Models\PermintaanSurat;
use App\Models\RiwayatStatus;
use App\Models\StatusPermintaanSurat;
use App\Models\VerifikasiPengguna;
use App\Models\VerifikasiSuratFinal;
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

        // Ambil semua permintaan surat user (tidak hanya yang sudah verified)
        $riwayatSurat = PermintaanSurat::with([
            'jenisSurat',
            'suratTerbit',
            'verifikasiPengguna',
            'statusPermintaan' => function ($query) {
                $query->with('user')->orderBy('tanggal_perubahan', 'desc');
            },
            'latestStatusPermintaan.user',
            'suratKeteranganMeninggalDunia',
            'suratKeteranganDomisili',
            'suratKeteranganUsaha',
            'suratKeteranganTidakMampu'
        ])
            ->where('verifikasi_pengguna_id', $verifikasiPengguna->id)
            ->orderBy('tanggal_permintaan', 'desc')
            ->paginate(10);

        return view('layouts.landing-page.riwayat.surat.index', compact('riwayatSurat'));
    }

    /**
     * Get detail riwayat status untuk modal
     */
    public function getRiwayatStatus($permintaanSuratId)
    {
        $permintaanSurat = PermintaanSurat::with([
            'statusPermintaan' => function ($query) {
                $query->with('user')->orderBy('tanggal_perubahan', 'asc');
            }
        ])->findOrFail($permintaanSuratId);

        $bagianList = ['Tata Usaha', 'Sekretaris Nagari', 'Wali Nagari'];
        $riwayatStatus = [];

        // Buat tracking berdasarkan status yang ada
        $statusData = $permintaanSurat->statusPermintaan->groupBy('status');

        foreach ($bagianList as $index => $bagian) {
            $status = 'Menunggu';
            $tanggalProses = null;
            $keterangan = 'Menunggu proses sebelumnya selesai';
            $petugas = '-';

            // Tentukan status berdasarkan data yang ada
            if ($permintaanSurat->status === 'Selesai') {
                $status = 'Selesai';
                $keterangan = 'Proses telah selesai';
                $tanggalProses = $permintaanSurat->updated_at->format('d/m/Y H:i');
                if ($statusSelesai = $statusData->get('Selesai')?->first()) {
                    $tanggalProses = $statusSelesai->tanggal_perubahan->format('d/m/Y H:i');
                    $petugas = $statusSelesai->user->name ?? 'System';
                }
            } elseif ($permintaanSurat->status === 'Ditolak') {
                if ($bagian === 'Tata Usaha') {  // Asumsi ditolak di Tata Usaha
                    $status = 'Ditolak';
                    $keterangan = $permintaanSurat->keterangan ?? 'Surat ditolak';
                    $tanggalProses = $permintaanSurat->updated_at->format('d/m/Y H:i');
                    if ($statusDitolak = $statusData->get('Ditolak')?->first()) {
                        $tanggalProses = $statusDitolak->tanggal_perubahan->format('d/m/Y H:i');
                        $petugas = $statusDitolak->user->name ?? 'System';
                    }
                }
            } else {
                // Status masih Diproses/Diterima - tentukan berdasarkan status
                if ($permintaanSurat->status === 'Diproses' && $bagian === 'Tata Usaha') {
                    $status = 'Sedang Diproses';
                    $keterangan = 'Sedang dalam proses verifikasi di Tata Usaha';
                    $tanggalProses = $permintaanSurat->tanggal_permintaan->format('d/m/Y H:i');
                } elseif ($permintaanSurat->status === 'Diterima') {
                    if ($bagian === 'Sekretaris Nagari') {
                        $status = 'Sedang Diproses';
                        $keterangan = 'Sedang dalam proses verifikasi di Sekretaris Nagari';
                        $tanggalProses = $permintaanSurat->updated_at->format('d/m/Y H:i');
                    } elseif ($bagian === 'Tata Usaha') {
                        $status = 'Selesai';
                        $keterangan = 'Telah disetujui Tata Usaha';
                        $tanggalProses = $permintaanSurat->updated_at->format('d/m/Y H:i');
                    }
                }

                // Override dengan data status jika ada
                if ($latestStatus = $permintaanSurat->latestStatusPermintaan) {
                    if ($latestStatus->bagian === $bagian) {
                        $status = 'Sedang Diproses';
                        $tanggalProses = $latestStatus->tanggal_perubahan->format('d/m/Y H:i');
                        $petugas = $latestStatus->user->name ?? 'System';
                    }
                }
            }

            $riwayatStatus[] = [
                'bagian' => $bagian,
                'status' => $status,
                'keterangan' => $keterangan,
                'tanggal_proses' => $tanggalProses,
                'petugas' => $petugas
            ];
        }

        return response()->json([
            'permintaan_surat' => $permintaanSurat,
            'riwayat_status' => $riwayatStatus
        ]);
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
