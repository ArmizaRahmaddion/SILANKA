<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganDomisili;
use App\Models\SuratKeteranganMeninggalDunia;
use App\Models\SuratKeteranganTidakMampu;
use App\Models\SuratKeteranganUsaha;
use App\Models\SuratTerbit;
use App\Models\VerifikasiSuratFinal;
use Illuminate\Http\Request;

class CekSuratController extends Controller
{
    /**
     * Halaman form cek surat
     */
    public function checkForm(Request $request)
    {
        $code = $request->get('code');

        return view('layouts.landing-page.check-validitas-surat.check-surat', compact('code'));
    }

    /**
     * Proses cek surat berdasarkan nomor surat
     */
    public function checkSurat(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
        ]);

        try {
            // Cari surat berdasarkan nomor surat
            $suratTerbit = SuratTerbit::where('nomor_surat', $request->nomor_surat)->first();

            if (! $suratTerbit) {
                return redirect()->back()->with('error', 'Nomor surat tidak ditemukan.');
            }

            // Cari verifikasi surat
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->with(['jenisSurat', 'verifiedBy'])
                ->first();

            if (! $verifikasi) {
                return redirect()->back()->with('error', 'Surat belum diverifikasi atau tidak valid.');
            }

            $kodeSurat = $verifikasi->jenisSurat->kode_surat;

            $suratData = match ($kodeSurat) {
                'SKKM' => SuratKeteranganMeninggalDunia::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKD' => SuratKeteranganDomisili::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKU' => SuratKeteranganUsaha::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKTM' => SuratKeteranganTidakMampu::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                // Tambahkan jenis surat lain sesuai kebutuhan
                default => null,
            };

            return view('layouts.landing-page.check-validitas-surat.check-hasil-surat', compact('verifikasi', 'suratTerbit', 'suratData'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Print surat dari hasil pengecekan (untuk public)
     */
    public function printSuratFromCheck($verifikasiId)
    {
        try {
            // Ambil data verifikasi + relasi
            $verifikasi = VerifikasiSuratFinal::with([
                'suratTerbit',
                'jenisSurat',
                'permintaanSurat',
            ])->findOrFail($verifikasiId);

            // Cek status verifikasi surat
            if (! $verifikasi->verified_at) {
                return redirect()->back()
                    ->with('error', 'Surat belum diverifikasi.');
            }

            // Pilih proses berdasarkan kode surat
            switch ($verifikasi->jenisSurat->kode_surat) {

                /* ======================= SKKM ======================= */
                case 'SKKM':
                    $suratData = SuratKeteranganMeninggalDunia::where(
                        'permintaan_surat_id',
                        $verifikasi->permintaan_surat_id
                    )->first();

                    if (! $suratData) {
                        return redirect()->back()
                            ->with('error', 'Data SKKM tidak ditemukan.');
                    }

                    return view(
                        'layouts.landing-page.check-validitas-surat.skkm-print',
                        compact('suratData', 'verifikasi')
                    );

                    /* ======================= SKD ======================== */
                case 'SKD':
                    $suratData = SuratKeteranganDomisili::where(
                        'permintaan_surat_id',
                        $verifikasi->permintaan_surat_id
                    )->first();

                    if (! $suratData) {
                        return redirect()->back()
                            ->with('error', 'Data SKD tidak ditemukan.');
                    }

                    return view(
                        'layouts.landing-page.check-validitas-surat.skd-print',
                        compact('suratData', 'verifikasi')
                    );

                    /* ======================= SKU ======================== */
                case 'SKU':
                    $suratData = SuratKeteranganUsaha::where(
                        'permintaan_surat_id',
                        $verifikasi->permintaan_surat_id
                    )->first();

                    if (! $suratData) {
                        return redirect()->back()
                            ->with('error', 'Data SKU tidak ditemukan.');
                    }

                    return view(
                        'layouts.landing-page.check-validitas-surat.sku-print',
                        compact('suratData', 'verifikasi')
                    );

                    /* ======================= SKTM ======================== */
                case 'SKTM':
                    $suratData = SuratKeteranganTidakMampu::where(
                        'permintaan_surat_id',
                        $verifikasi->permintaan_surat_id
                    )->first();

                    if (! $suratData) {
                        return redirect()->back()
                            ->with('error', 'Data SKTM tidak ditemukan.');
                    }

                    return view(
                        'layouts.landing-page.check-validitas-surat.sktm-print',
                        compact('suratData', 'verifikasi')
                    );

                    /* ============ Tambahkan case lain di sini ============ */

                default:
                    return redirect()->back()
                        ->with('error', 'Jenis surat tidak didukung untuk print.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
