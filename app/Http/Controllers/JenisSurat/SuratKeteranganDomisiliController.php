<?php

namespace App\Http\Controllers\JenisSurat;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PermintaanSurat;
use App\Models\SuratKeteranganDomisili;
use App\Models\VerifikasiSuratFinal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKeteranganDomisiliController extends Controller
{
    public function index()
    {
        $skd = SuratKeteranganDomisili::with(['permintaanSurat.suratTerbit'])->get();

        return view('layouts.admin.layanan.e-surat.skd.list', compact('skd'));
    }

    public function create()
    {
        $jenisSuratId = JenisSurat::where('kode_surat', 'SKD')->first()->id;
        $verifikasi = Auth::user()->verifikasi;

        return view('layouts.landing-page.layanan.surat.skd-form', compact('jenisSuratId', 'verifikasi'));
    }

    public function store(Request $request)
    {
        Carbon::setlocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'verifikasi_pengguna_id' => 'required|exists:verifikasi_pengguna,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-Laki,perempuan',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);


        try {
            // Format kapitalisasi awal kata
            $nama = ucwords(strtolower($request->nama));
            $tempatLahir = ucwords(strtolower($request->tempat_lahir));
            $statusPerkawinan = ucwords(strtolower($request->status_perkawinan));
            $jenisKelamin = ucwords(strtolower($request->jenis_kelamin));
            $agama = ucwords(strtolower($request->agama));
            $pekerjaan = ucwords(strtolower($request->pekerjaan));
            $alamat = ucwords(strtolower($request->alamat));
            $keperluan = ucfirst(strtolower($request->keperluan)); // Awal kalimat kapital

            // Simpan permintaan surat
            $permintaan = PermintaanSurat::create([
                'tanggal_permintaan' => now(),
                'status' => 'Diproses',
                'jenis_surat_id' => $request->jenis_surat_id,
                'verifikasi_pengguna_id' => $request->verifikasi_pengguna_id,
            ]);

            // Simpan surat domisili
            $surat = SuratKeteranganDomisili::create([
                'permintaan_surat_id' => $permintaan->id,
                'keperluan' => $keperluan,
                'nama' => $nama,
                'nik' => $request->nik,
                'tempat_lahir' => $tempatLahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'status_perkawinan' => $statusPerkawinan,
                'jenis_kelamin' => $jenisKelamin,
                'agama' => $agama,
                'pekerjaan' => $pekerjaan,
                'alamat' => $alamat,
            ]);

            Alert::success(
                'Pengajuan Berhasil!',
                'Terima kasih telah menggunakan SILANKA. Surat Anda sedang diproses. Mohon cek status surat secara berkala untuk informasi selanjutnya.'
            );

            return redirect()->route('surat.skd');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        try {
            // Format input agar kapital
            $nama = ucwords(strtolower($request->nama));
            $tempatLahir = ucwords(strtolower($request->tempat_lahir));
            $statusPerkawinan = ucwords(strtolower($request->status_perkawinan));
            $jenisKelamin = ucwords(strtolower($request->jenis_kelamin));
            $agama = ucwords(strtolower($request->agama));
            $pekerjaan = ucwords(strtolower($request->pekerjaan));
            $alamat = ucwords(strtolower($request->alamat));
            $keperluan = ucfirst(strtolower($request->keperluan));

            // Ambil data surat
            $surat = SuratKeteranganDomisili::findOrFail($id);

            // Update data surat
            $surat->update([
                'keperluan' => $keperluan,
                'nama' => $nama,
                'nik' => $request->nik,
                'tempat_lahir' => $tempatLahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'status_perkawinan' => $statusPerkawinan,
                'jenis_kelamin' => $jenisKelamin,
                'agama' => $agama,
                'pekerjaan' => $pekerjaan,
                'alamat' => $alamat,
            ]);

            Alert::success('Berhasil!', 'Data surat berhasil diperbarui.');

            return redirect()->route('skd.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function print($id)
    {
        try {
            // Ambil data surat dengan relasi
            $skd = SuratKeteranganDomisili::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            // Ambil data surat terbit jika ada
            $suratTerbit = $skd->permintaanSurat->suratTerbit->first();

            // Cek apakah surat sudah diterbitkan
            if (! $suratTerbit) {
                return redirect()->back()->with('error', 'Surat belum diterbitkan. Tidak dapat mencetak.');
            }

            // Cek apakah surat sudah diverifikasi dan memiliki barcode
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            return view('layouts.admin.layanan.e-surat.skd.template-with-barcode', compact('skd', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function redirectPreview($id)
    {
        try {
            $skd = SuratKeteranganDomisili::with([
                'permintaanSurat.suratTerbit',
            ])->findOrFail($id);

            $suratTerbit = $skd->permintaanSurat->suratTerbit->first();

            // Cek apakah sudah diverifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if ($verifikasi) {
                return redirect()->route('verifikasi.skd.preview', $id);
            } else {
                return redirect()->route('skd.preview', $id);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Preview surat sebelum print (untuk surat yang belum diverifikasi)
     */
    public function preview($id)
    {
        try {
            $skd = SuratKeteranganDomisili::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $skd->permintaanSurat->suratTerbit->first();

            return view('layouts.admin.layanan.e-surat.skd.preview', compact('skd', 'suratTerbit'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Preview surat yang sudah diverifikasi dengan barcode
     */
    public function previewVerified($id)
    {
        try {
            $skd = SuratKeteranganDomisili::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $skd->permintaanSurat->suratTerbit->first();

            // Ambil data verifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if (! $verifikasi) {
                return redirect()->back()->with('error', 'Surat belum diverifikasi.');
            }

            return view('layouts.admin.layanan.e-surat.skd.preview-verified', compact('skd', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function ajukanTtd($suratId)
    {
        try {
            // Cari data surat berdasarkan ID (misalnya SKKM)
            $surat = SuratKeteranganDomisili::findOrFail($suratId);
            $permintaanSurat = $surat->permintaanSurat;
            $suratTerbit = $permintaanSurat->suratTerbit->first();

            // Validasi status surat harus "Diterima"
            if ($permintaanSurat->status !== 'Diterima') {
                return redirect()->back()->with('error', 'Surat harus berstatus "Diterima" untuk dapat diajukan TTD.');
            }

            // Cek apakah sudah pernah diajukan
            $existingVerifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)->first();
            if ($existingVerifikasi) {
                return redirect()->back()->with('error', 'Surat ini sudah pernah diajukan untuk verifikasi.');
            }

            // Buat record verifikasi baru
            VerifikasiSuratFinal::create([
                'surat_terbit_id' => $suratTerbit->id,
                'jenis_surat_id' => $permintaanSurat->jenis_surat_id,
                'permintaan_surat_id' => $permintaanSurat->id,
                'barcode' => null, // akan diisi saat verifikasi
                'verified_at' => null,
                'verified_by' => null,
            ]);

            return redirect()->back()->with('success', 'Pengajuan TTD berhasil dikirim ke sekretaris untuk verifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}