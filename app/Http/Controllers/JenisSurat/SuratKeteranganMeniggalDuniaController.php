<?php

namespace App\Http\Controllers\JenisSurat;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PermintaanSurat;
use App\Models\SuratKeteranganMeninggalDunia;
use App\Models\VerifikasiSuratFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKeteranganMeniggalDuniaController extends Controller
{
    public function index()
    {
        $skkm = SuratKeteranganMeninggalDunia::with(['permintaanSurat.suratTerbit'])->get();

        return view('layouts.admin.layanan.e-surat.skkm.list', compact('skkm'));
    }

    public function create()
    {
        $jenisSuratId = JenisSurat::where('kode_surat', 'SKKM')->first()->id;
        $verifikasi = Auth::user()->verifikasi;

        return view('layouts.landing-page.layanan.surat.skkm-form', compact('jenisSuratId', 'verifikasi'));
    }

    public function store(Request $request)
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'verifikasi_pengguna_id' => 'required|exists:verifikasi_pengguna,id',
            'nama_almarhum' => 'required|string|max:255',
            'nik_almarhum' => 'required|digits:16',
            'tempat_lahir_almarhum' => 'required|string|max:255',
            'tanggal_lahir_almarhum' => 'required|date',
            'jenis_kelamin_almarhum' => 'required|in:Laki-laki,Perempuan',
            'agama_almarhum' => 'required|string|max:50',
            'alamat_almarhum' => 'required|string',
            'tanggal_meninggal' => 'required|date',
        ]);

        try {
            // Format input (otomatis kapital awal huruf)
            $keperluan = ucfirst(strtolower($request->keperluan));
            $nama = ucwords(strtolower($request->nama_almarhum));
            $tempatLahir = ucwords(strtolower($request->tempat_lahir_almarhum));
            $jenisKelamin = ucwords(strtolower($request->jenis_kelamin_almarhum));
            $agama = ucwords(strtolower($request->agama_almarhum));
            $alamat = ucwords(strtolower($request->alamat_almarhum));

            // Simpan ke permintaan_surat
            $permintaan = PermintaanSurat::create([
                'tanggal_permintaan' => now(),
                'status' => 'Diproses',
                'jenis_surat_id' => $request->jenis_surat_id,
                'verifikasi_pengguna_id' => $request->verifikasi_pengguna_id,
            ]);

            // Simpan ke surat_keterangan_meninggal_dunia
            $surat = SuratKeteranganMeninggalDunia::create([
                'permintaan_surat_id' => $permintaan->id,
                'keperluan' => $keperluan,
                'nama_almarhum' => $nama,
                'nik_almarhum' => $request->nik_almarhum,
                'tempat_lahir_almarhum' => $tempatLahir,
                'tanggal_lahir_almarhum' => $request->tanggal_lahir_almarhum,
                'jenis_kelamin_almarhum' => $jenisKelamin,
                'agama_almarhum' => $agama,
                'alamat_almarhum' => $alamat,
                'tanggal_meninggal' => $request->tanggal_meninggal,
            ]);

            Alert::success(
                'Pengajuan Berhasil!',
                'Terima kasih telah menggunakan SILANKA. Surat Anda sedang diproses. Mohon cek status surat secara berkala untuk informasi selanjutnya.'
            );

            return redirect()->route('surat.skkm');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: '.$e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',
            'nama_almarhum' => 'required|string|max:255',
            'nik_almarhum' => 'required|digits:16',
            'tempat_lahir_almarhum' => 'required|string|max:255',
            'tanggal_lahir_almarhum' => 'required|date',
            'jenis_kelamin_almarhum' => 'required|in:Laki-laki,Perempuan',
            'agama_almarhum' => 'required|string|max:50',
            'alamat_almarhum' => 'required|string',
            'tanggal_meninggal' => 'required|date',
        ]);

        try {
            // Format input agar kapital
            $keperluan = ucfirst(strtolower($request->keperluan));
            $nama = ucwords(strtolower($request->nama_almarhum));
            $tempatLahir = ucwords(strtolower($request->tempat_lahir_almarhum));
            $jenisKelamin = ucwords(strtolower($request->jenis_kelamin_almarhum));
            $agama = ucwords(strtolower($request->agama_almarhum));
            $alamat = ucwords(strtolower($request->alamat_almarhum));

            // Ambil data surat
            $surat = SuratKeteranganMeninggalDunia::findOrFail($id);

            // Update data surat
            $surat->update([
                'keperluan' => $keperluan,
                'nama_almarhum' => $nama,
                'nik_almarhum' => $request->nik_almarhum,
                'tempat_lahir_almarhum' => $tempatLahir,
                'tanggal_lahir_almarhum' => $request->tanggal_lahir_almarhum,
                'jenis_kelamin_almarhum' => $jenisKelamin,
                'agama_almarhum' => $agama,
                'alamat_almarhum' => $alamat,
                'tanggal_meninggal' => $request->tanggal_meninggal,
            ]);

            Alert::success('Berhasil!', 'Data surat berhasil diperbarui.');

            return redirect()->route('skkm.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: '.$e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Print surat SKKM dengan barcode (untuk surat yang sudah diverifikasi)
     */
    public function print($id)
    {
        try {
            // Ambil data SKKM dengan relasi
            $skkm = SuratKeteranganMeninggalDunia::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            // Ambil data surat terbit jika ada
            $suratTerbit = $skkm->permintaanSurat->suratTerbit->first();

            // Cek apakah surat sudah diterbitkan
            if (! $suratTerbit) {
                return redirect()->back()->with('error', 'Surat belum diterbitkan. Tidak dapat mencetak.');
            }

            // Cek apakah surat sudah diverifikasi dan memiliki barcode
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            return view('layouts.admin.layanan.e-surat.skkm.template-with-barcode', compact('skkm', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: '.$e->getMessage());
        }
    }

    public function redirectPreview($id)
    {
        try {
            $skkm = SuratKeteranganMeninggalDunia::with([
                'permintaanSurat.suratTerbit',
            ])->findOrFail($id);

            $suratTerbit = $skkm->permintaanSurat->suratTerbit->first();

            // Cek apakah sudah diverifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if ($verifikasi) {
                return redirect()->route('verifikasi.skkm.preview', $id);
            } else {
                return redirect()->route('skkm.preview', $id);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: '.$e->getMessage());
        }
    }

    /**
     * Preview surat sebelum print (untuk surat yang belum diverifikasi)
     */
    public function preview($id)
    {
        try {
            $skkm = SuratKeteranganMeninggalDunia::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $skkm->permintaanSurat->suratTerbit->first();

            return view('layouts.admin.layanan.e-surat.skkm.preview', compact('skkm', 'suratTerbit'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: '.$e->getMessage());
        }
    }

    /**
     * Preview surat yang sudah diverifikasi dengan barcode
     */
    public function previewVerified($id)
    {
        try {
            $skkm = SuratKeteranganMeninggalDunia::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $skkm->permintaanSurat->suratTerbit->first();

            // Ambil data verifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if (! $verifikasi) {
                return redirect()->back()->with('error', 'Surat belum diverifikasi.');
            }

            return view('layouts.admin.layanan.e-surat.skkm.preview-verified', compact('skkm', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: '.$e->getMessage());
        }
    }
}
