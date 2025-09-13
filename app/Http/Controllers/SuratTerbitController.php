<?php

namespace App\Http\Controllers;

use App\Models\PermintaanSurat;
use App\Models\SuratTerbit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SuratTerbitController extends Controller
{
    /**
     * Menampilkan halaman form buat surat
     */
    public function showBuatSurat($id)
    {
        try {
            // Ambil data permintaan surat lengkap
            $permintaan = PermintaanSurat::with([
                'jenisSurat',
                'verifikasiPengguna',
                'suratKeteranganMeninggalDunia',
                'suratKeteranganDomisili',
                'suratKeteranganUsaha',
                'suratKeteranganTidakMampu',
            ])->findOrFail($id);

            // Pastikan status surat masih bisa diproses
            if ($permintaan->status !== 'Diproses') {
                return redirect()->route('permintaan.surat')
                    ->with('error', 'Permintaan surat ini sudah diproses atau tidak dapat diubah.');
            }

            // Tentukan jenis surat
            $jenisSuratId = $permintaan->jenis_surat_id;

            // Generate nomor surat otomatis
            $nomorSurat = $this->generateNomorSurat($jenisSuratId);

            switch ($jenisSuratId) {
                case 1: //  1 = Surat Keterangan Meninggal Dunia
                    $suratData = $permintaan->suratKeteranganMeninggalDunia;
                    if (! $suratData) {
                        return redirect()->route('permintaan.surat')
                            ->with('error', 'Data surat Keterangan meninggal dunia tidak ditemukan.');
                    }

                    return view('layouts.admin.permintaan-surat.surat-keterangan-meninggal-dunia.skkm-create', compact('permintaan', 'suratData', 'nomorSurat'));

                case 2: //  2 = Surat Keterangan Domisili
                    $suratData = $permintaan->suratKeteranganDomisili;
                    if (! $suratData) {
                        return redirect()->route('permintaan.surat')
                            ->with('error', 'Data surat Keterangan domisili tidak ditemukan.');
                    }

                    return view('layouts.admin.permintaan-surat.surat-keterangan-domisili.skd-create', compact('permintaan', 'suratData', 'nomorSurat'));

                case 3: //  3 = Surat Keterangan Usaha
                    $suratData = $permintaan->suratKeteranganUsaha;
                    if (! $suratData) {
                        return redirect()->route('permintaan.surat')
                            ->with('error', 'Data surat Keterangan Usaha tidak ditemukan.');
                    }

                    return view('layouts.admin.permintaan-surat.surat-keterangan-usaha.sku-create', compact('permintaan', 'suratData', 'nomorSurat'));

                case 4: //  4 = Surat Keterangan Tidak Mampu
                    $suratData = $permintaan->suratKeteranganTidakMampu;
                    if (! $suratData) {
                        return redirect()->route('permintaan.surat')
                            ->with('error', 'Data surat Keterangan Tidak Mampu tidak ditemukan.');
                    }

                    return view('layouts.admin.permintaan-surat.surat-keterangan-tidak-mampu.sktm-create', compact('permintaan', 'suratData', 'nomorSurat'));
                    // Tambahkan jenis surat lain jika ada
                default:
                    return redirect()->route('permintaan.surat')
                        ->with('error', 'Jenis surat tidak dikenali.');
            }
        } catch (\Exception $e) {
            return redirect()->route('permintaan.surat')
                ->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Menyimpan surat yang sudah dibuat
     */
    public function simpanSurat(Request $request, $id)
    {
        try {
            // Validasi input nomor surat
            $validated = $request->validate([
                'nomor_surat' => 'required|string|max:100|unique:surat_terbit,nomor_surat',
            ]);

            // Ambil permintaan surat beserta semua kemungkinan relasi surat
            $permintaan = PermintaanSurat::with([
                'suratKeteranganMeninggalDunia',
                'suratKeteranganDomisili',
                'suratKeteranganUsaha',
                'suratKeteranganTidakMampu',
                // Tambahkan relasi surat lain jika ada
            ])->findOrFail($id);

            if ($permintaan->status !== 'Diproses') {
                return redirect()->route('permintaan.surat')
                    ->with('error', 'Permintaan surat ini sudah diproses atau tidak dapat diubah.');
            }

            // Cek apakah data surat tersedia sesuai jenis_surat_id
            $jenisSuratId = $permintaan->jenis_surat_id;
            $suratAda = match ($jenisSuratId) {
                1 => $permintaan->suratKeteranganMeninggalDunia,
                2 => $permintaan->suratKeteranganDomisili,
                3 => $permintaan->suratKeteranganUsaha,
                4 => $permintaan->suratKeteranganTidakMampu,
                // Tambahkan jenis surat lain jika ada
                default => null,
            };

            if (! $suratAda) {
                return redirect()->route('permintaan.surat')
                    ->with('error', 'Data surat tidak ditemukan.');
            }

            // Simpan surat terbit
            $suratTerbit = SuratTerbit::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal_terbit' => now(),
                'permintaan_surat_id' => $permintaan->id,
                'jenis_surat_id' => $jenisSuratId,
            ]);

            // Ubah status permintaan jadi Diterima
            $permintaan->update(['status' => 'Diterima']);

            Alert::success(
                'Surat berhasil dibuat dengan nomor: '.$request->nomor_surat
            );

            return redirect()->route('permintaan.surat');
            // ->with('success', 'Surat berhasil diterbitkan dengan nomor: ' . $request->nomor_surat);
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: '.$e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Generate nomor surat otomatis
     */
    private function generateNomorSurat($jenisSuratId)
    {
        $today = date('Y-m-d');
        $year = date('Y');

        // Tentukan kode surat berdasarkan jenis_surat_id
        $kodeSurat = match ($jenisSuratId) {
            1 => 'SKKM', // Surat Keterangan Kematian/Meninggal
            2 => 'SKD',  // Surat Keterangan Domisili
            3 => 'SKU',  // Surat Keterangan Usaha
            4 => 'SKTM',  // Surat Keterangan Tidak Mampu
            default => 'LAINNYA',
        };

        // Hitung jumlah surat yang sudah dibuat hari ini
        $count = '...';

        // Format: TAHUN/SKKM/BULAN/URUTAN
        return sprintf('%s/%s/WN-KA/%03d', $count, $kodeSurat, $year);
    }
}
