<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganDomisili;
use App\Models\SuratKeteranganMeninggalDunia;
use App\Models\SuratKeteranganTidakMampu;
use App\Models\SuratKeteranganUsaha;
use App\Models\VerifikasiSuratFinal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VerifikasiSuratFinalController extends Controller
{
    /**
     * Halaman daftar surat yang perlu diverifikasi (khusus sekretaris)
     */
    public function finalIndex()
    {
        $verifikasiSurat = VerifikasiSuratFinal::with([
            'suratTerbit',
            'permintaanSurat',
            'jenisSurat',
            'permintaanSurat.suratKeteranganMeninggalDunia',
            'permintaanSurat.suratKeteranganDomisili',
            'permintaanSurat.suratKeteranganUsaha',
            'verifiedBy',
        ])
            ->whereNull('verified_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.admin.verifikasi-final.list', compact('verifikasiSurat'));
    }

    /**
     * Verifikasi dengan GD yang sudah terinstall
     */
    public function verifikasi($id)
    {
        try {
            $verifikasi = VerifikasiSuratFinal::findOrFail($id);

            if ($verifikasi->verified_at) {
                return redirect()->back()->with('error', 'Surat ini sudah diverifikasi sebelumnya.');
            }

            $nomorSurat = $verifikasi->suratTerbit->nomor_surat;
            $uniqueCode = $nomorSurat.'-'.time().'-'.Str::random(6);

            // Generate URL untuk cek surat
            // $checkUrl = route('surat.check.form') . '?code=' . urlencode($uniqueCode);
            $checkUrl = url(route('surat.check.form', [], false)).'?code='.urlencode($uniqueCode);

            // Generate QR Code dengan URL cek surat
            $barcodePath = $this->generateQrCodeWithGD($checkUrl);

            if (! $barcodePath) {
                return redirect()->back()->with('error', 'Gagal generate barcode.');
            }

            $verifikasi->update([
                'barcode' => $barcodePath,
                'barcode_data' => $uniqueCode, // simpan kode unik untuk pengecekan
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            $verifikasi->permintaanSurat->update([
                'status' => 'Selesai',
            ]);

            return redirect()->route('verifikasi.index')->with('success', 'Surat berhasil diverifikasi dan barcode telah digenerate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Halaman daftar surat yang sudah terverifikasi
     */
    public function verifiedIndex()
    {
        $verifikasiSurat = VerifikasiSuratFinal::with([
            'suratTerbit',
            'permintaanSurat',
            'jenisSurat',
            'permintaanSurat.suratKeteranganMeninggalDunia',
            'permintaanSurat.suratKeteranganDomisili',
            'permintaanSurat.suratKeteranganUsaha',
            'verifiedBy',
        ])
            ->whereNotNull('verified_at')
            ->orderBy('verified_at', 'desc')
            ->get();

        return view('layouts.admin.verifikasi-final.terverifikasi-list', compact('verifikasiSurat'));
    }

    /**
     * Generate QR Code dengan BaconQrCode
     */
    private function generateQrCodeWithGD($data, $filename = null)
    {
        try {
            $qrCode = QrCode::format('svg')
                ->size(200)
                ->margin(1)
                ->generate($data);

            // Pastikan folder ada
            Storage::disk('public')->makeDirectory('barcodes');

            $filename = $filename ?? 'barcode_'.time().'.svg';
            Storage::disk('public')->put('barcodes/'.$filename, $qrCode);

            return 'barcodes/'.$filename;
        } catch (\Exception $e) {
            \Log::error('QR Code generation error: '.$e->getMessage());

            return null;
        }
    }

    public function ajukanTtd($kodeSurat, $suratId)
    {
        try {
            // Tentukan model berdasarkan jenis surat
            switch ($kodeSurat) {
                case 'SKKM':
                    $surat = SuratKeteranganMeninggalDunia::findOrFail($suratId);
                    break;
                case 'SKD':
                    $surat = SuratKeteranganDomisili::findOrFail($suratId);
                    break;
                case 'SKU':
                    $surat = SuratKeteranganUsaha::findOrFail($suratId);
                    break;

                case 'SKTM':
                    $surat = SuratKeteranganTidakMampu::findOrFail($suratId);
                    break;
                    // Tambahkan jenis surat lainnya di sini
                default:
                    return redirect()->back()->with('error', 'Jenis surat tidak dikenali.');
            }

            $permintaanSurat = $surat->permintaanSurat;
            $suratTerbit = $permintaanSurat->suratTerbit->first();

            if ($permintaanSurat->status !== 'Diterima') {
                return redirect()->back()->with('error', 'Surat harus berstatus "Diterima" untuk diajukan TTD.');
            }

            // Cek apakah sudah pernah diajukan
            $existingVerifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)->first();
            if ($existingVerifikasi) {
                return redirect()->back()->with('error', 'Surat ini sudah diajukan sebelumnya.');
            }

            // Simpan verifikasi
            VerifikasiSuratFinal::create([
                'surat_terbit_id' => $suratTerbit->id,
                'jenis_surat_id' => $permintaanSurat->jenis_surat_id,
                'permintaan_surat_id' => $permintaanSurat->id,
                'barcode' => null,
                'verified_at' => null,
                'verified_by' => null,
            ]);

            return redirect()->back()->with('success', 'Pengajuan TTD berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
