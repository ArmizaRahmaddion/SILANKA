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
    public function checkForm()
    {
        return view('layouts.landing-page.check-validitas-surat.check-surat');
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
                'jenisSurat',
                'suratTerbit',
                'verifiedBy',
            ])->findOrFail($verifikasiId);

            // Cek status verifikasi surat
            if (! $verifikasi->verified_at) {
                return redirect()->back()->with('error', 'Surat belum diverifikasi.');
            }

            $kodeSurat = $verifikasi->jenisSurat->kode_surat;

            $suratData = match ($kodeSurat) {
                'SKKM' => SuratKeteranganMeninggalDunia::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKD' => SuratKeteranganDomisili::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKU' => SuratKeteranganUsaha::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                'SKTM' => SuratKeteranganTidakMampu::where('permintaan_surat_id', $verifikasi->permintaan_surat_id)->first(),
                default => null,
            };

            if (! $suratData) {
                return redirect()->back()->with('error', 'Data surat tidak ditemukan.');
            }

            $view = match ($kodeSurat) {
                'SKKM' => 'layouts.landing-page.check-validitas-surat.skkm-print',
                'SKD' => 'layouts.landing-page.check-validitas-surat.skd-print',
                'SKU' => 'layouts.landing-page.check-validitas-surat.sku-print',
                'SKTM' => 'layouts.landing-page.check-validitas-surat.sktm-print',
                default => null,
            };

            if (! $view) {
                return redirect()->back()->with('error', 'Jenis surat tidak didukung untuk print.');
            }

            return view($view, compact('suratData', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
