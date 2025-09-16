<?php

namespace App\Http\Controllers\JenisSurat;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PermintaanSurat;
use App\Models\SuratKeteranganTidakMampu;
use App\Models\VerifikasiSuratFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKeteranganTidakMampuController extends Controller
{
    public function index()
    {
        $sktm = SuratKeteranganTidakMampu::with(['permintaanSurat.suratTerbit', 'tanggungJawab'])->get();

        return view('layouts.admin.layanan.e-surat.sktm.list', compact('sktm'));
    }

    public function create()
    {
        $jenisSuratId = JenisSurat::where('kode_surat', 'SKTM')->first()->id;
        $verifikasi = Auth::user()->verifikasi;

        return view('layouts.landing-page.layanan.surat.sktm-form', compact('jenisSuratId', 'verifikasi'));
    }

    public function store(Request $request)
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'verifikasi_pengguna_id' => 'required|exists:verifikasi_pengguna,id',

            // Anak
            'anak.nama' => 'required|string|max:255',
            'anak.nik' => 'required|digits:16',
            'anak.tempat_lahir' => 'required|string|max:255',
            'anak.tanggal_lahir' => 'required|date',
            'anak.status_perkawinan' => 'required|string|max:20',
            'anak.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'anak.pekerjaan' => 'required|string|max:255',
            'anak.alamat' => 'required|string',

            // Orang Tua
            'ortu.nama' => 'required|string|max:255',
            'ortu.nik' => 'required|digits:16',
            'ortu.tempat_lahir' => 'required|string|max:255',
            'ortu.tanggal_lahir' => 'required|date',
            'ortu.status_perkawinan' => 'required|string|max:20',
            'ortu.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'ortu.pekerjaan' => 'required|string|max:255',
            'ortu.alamat' => 'required|string',

            // Tanggung Jawab
            'tanggung_jawab' => 'required|array|min:1',
            'tanggung_jawab.*.nama' => 'required|string|max:255',
            'tanggung_jawab.*.umur' => 'required|integer|min:0',
            'tanggung_jawab.*.pekerjaan' => 'required|string|max:100',
            'tanggung_jawab.*.keterangan' => 'required|string|max:255',
        ]);

        try {
            // Format kapitalisasi
            $keperluan = ucfirst(strtolower($request->keperluan));

            // Anak
            $anak = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->anak);

            // Orang tua
            $ortu = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->ortu);

            // Simpan ke permintaan_surat
            $permintaan = PermintaanSurat::create([
                'tanggal_permintaan' => now(),
                'status' => 'Diproses',
                'jenis_surat_id' => $request->jenis_surat_id,
                'verifikasi_pengguna_id' => $request->verifikasi_pengguna_id,
            ]);

            // Simpan surat SKTM
            $surat = SuratKeteranganTidakMampu::create([
                'permintaan_surat_id' => $permintaan->id,
                'keperluan' => $keperluan,

                // Anak
                'anak_nama' => $anak['nama'],
                'anak_nik' => $anak['nik'],
                'anak_tempat_lahir' => $anak['tempat_lahir'],
                'anak_tanggal_lahir' => $anak['tanggal_lahir'],
                'anak_status_perkawinan' => $anak['status_perkawinan'],
                'anak_jenis_kelamin' => $anak['jenis_kelamin'],
                'anak_pekerjaan' => $anak['pekerjaan'],
                'anak_alamat' => $anak['alamat'],

                // Orang Tua
                'ortu_nama' => $ortu['nama'],
                'ortu_nik' => $ortu['nik'],
                'ortu_tempat_lahir' => $ortu['tempat_lahir'],
                'ortu_tanggal_lahir' => $ortu['tanggal_lahir'],
                'ortu_status_perkawinan' => $ortu['status_perkawinan'],
                'ortu_jenis_kelamin' => $ortu['jenis_kelamin'],
                'ortu_pekerjaan' => $ortu['pekerjaan'],
                'ortu_alamat' => $ortu['alamat'],
            ]);

            // Simpan anggota tanggung jawab
            foreach ($validated['tanggung_jawab'] as $tj) {
                $surat->tanggungJawab()->create([
                    'nama' => ucwords(strtolower($tj['nama'])),
                    'umur' => $tj['umur'],
                    'pekerjaan' => ucwords(strtolower($tj['pekerjaan'])),
                    'keterangan' => ucfirst(strtolower($tj['keterangan'])),
                ]);
            }

            Alert::success(
                'Pengajuan Berhasil!',
                'Terima kasih telah menggunakan SILANKA. Surat Anda sedang diproses. Mohon cek status surat secara berkala.'
            );

            return redirect()->route('surat.sktm');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());

            return back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'keperluan' => 'required|string|max:255',

            // Anak
            'anak.nama' => 'required|string|max:255',
            'anak.nik' => 'required|digits:16',
            'anak.tempat_lahir' => 'required|string|max:255',
            'anak.tanggal_lahir' => 'required|date',
            'anak.status_perkawinan' => 'required|string|max:20',
            'anak.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'anak.pekerjaan' => 'required|string|max:255',
            'anak.alamat' => 'required|string',

            // Orang Tua
            'ortu.nama' => 'required|string|max:255',
            'ortu.nik' => 'required|digits:16',
            'ortu.tempat_lahir' => 'required|string|max:255',
            'ortu.tanggal_lahir' => 'required|date',
            'ortu.status_perkawinan' => 'required|string|max:20',
            'ortu.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'ortu.pekerjaan' => 'required|string|max:255',
            'ortu.alamat' => 'required|string',

            // Tanggung Jawab (opsional tergantung apakah ingin diedit juga)
            'tanggung_jawab' => 'nullable|array',
            'tanggung_jawab.*.nama' => 'required_with:tanggung_jawab|string|max:255',
            'tanggung_jawab.*.umur' => 'required_with:tanggung_jawab|integer|min:0',
            'tanggung_jawab.*.pekerjaan' => 'required_with:tanggung_jawab|string|max:100',
            'tanggung_jawab.*.keterangan' => 'required_with:tanggung_jawab|string|max:255',
        ]);

        try {
            // Ambil surat
            $surat = SuratKeteranganTidakMampu::findOrFail($id);

            // Format kapitalisasi
            $keperluan = ucfirst(strtolower($request->keperluan));

            // Anak
            $anak = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->anak);

            // Orang tua
            $ortu = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->ortu);

            // Update data surat
            $surat->update([
                'keperluan' => $keperluan,

                // Anak
                'anak_nama' => $anak['nama'],
                'anak_nik' => $anak['nik'],
                'anak_tempat_lahir' => $anak['tempat_lahir'],
                'anak_tanggal_lahir' => $anak['tanggal_lahir'],
                'anak_status_perkawinan' => $anak['status_perkawinan'],
                'anak_jenis_kelamin' => $anak['jenis_kelamin'],
                'anak_pekerjaan' => $anak['pekerjaan'],
                'anak_alamat' => $anak['alamat'],

                // Orang Tua
                'ortu_nama' => $ortu['nama'],
                'ortu_nik' => $ortu['nik'],
                'ortu_tempat_lahir' => $ortu['tempat_lahir'],
                'ortu_tanggal_lahir' => $ortu['tanggal_lahir'],
                'ortu_status_perkawinan' => $ortu['status_perkawinan'],
                'ortu_jenis_kelamin' => $ortu['jenis_kelamin'],
                'ortu_pekerjaan' => $ortu['pekerjaan'],
                'ortu_alamat' => $ortu['alamat'],
            ]);

            // Jika tanggung_jawab dikirim ulang (re-edit), maka update ulang semua
            if (! empty($validated['tanggung_jawab'])) {
                $surat->tanggungJawab()->delete(); // Hapus yang lama

                foreach ($validated['tanggung_jawab'] as $tj) {
                    $surat->tanggungJawab()->create([
                        'nama' => ucwords(strtolower($tj['nama'])),
                        'umur' => $tj['umur'],
                        'pekerjaan' => ucwords(strtolower($tj['pekerjaan'])),
                        'keterangan' => ucfirst(strtolower($tj['keterangan'])),
                    ]);
                }
            }

            Alert::success('Berhasil!', 'Data surat berhasil diperbarui.');

            return redirect()->route('surat.sktm');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());

            return back()->withInput();
        }
    }

    public function print($id)
    {
        try {
            // Ambil data surat dengan relasi
            $sktm = SuratKeteranganTidakMampu::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            // Ambil data surat terbit jika ada
            $suratTerbit = $sktm->permintaanSurat->suratTerbit->first();

            // Cek apakah surat sudah diterbitkan
            if (! $suratTerbit) {
                return redirect()->back()->with('error', 'Surat belum diterbitkan. Tidak dapat mencetak.');
            }

            // Cek apakah surat sudah diverifikasi dan memiliki barcode
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            return view('layouts.admin.layanan.e-surat.sktm.template-with-barcode', compact('sktm', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function redirectPreview($id)
    {
        try {
            $sktm = SuratKeteranganTidakMampu::with([
                'permintaanSurat.suratTerbit',
            ])->findOrFail($id);

            $suratTerbit = $sktm->permintaanSurat->suratTerbit->first();

            // Cek apakah sudah diverifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if ($verifikasi) {
                return redirect()->route('verifikasi.sktm.preview', $id);
            } else {
                return redirect()->route('sktm.preview', $id);
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
            $sktm = SuratKeteranganTidakMampu::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $sktm->permintaanSurat->suratTerbit->first();

            return view('layouts.admin.layanan.e-surat.sktm.preview', compact('sktm', 'suratTerbit'));
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
            $sktm = SuratKeteranganTidakMampu::with([
                'permintaanSurat.suratTerbit',
                'permintaanSurat.jenisSurat',
            ])->findOrFail($id);

            $suratTerbit = $sktm->permintaanSurat->suratTerbit->first();

            // Ambil data verifikasi
            $verifikasi = VerifikasiSuratFinal::where('surat_terbit_id', $suratTerbit->id)
                ->whereNotNull('verified_at')
                ->first();

            if (! $verifikasi) {
                return redirect()->back()->with('error', 'Surat belum diverifikasi.');
            }

            return view('layouts.admin.layanan.e-surat.sktm.preview-verified', compact('sktm', 'suratTerbit', 'verifikasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function ajukanTtd($suratId)
    {
        try {
            // Cari data surat berdasarkan ID (misalnya SKKM)
            $surat = SuratKeteranganTidakMampu::findOrFail($suratId);
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

    // public function storeFromAdmin(Request $request)
    // {
    //     Carbon::setLocale('id');

    //     $validated = $request->validate([
    //         'keperluan' => 'required|string|max:255',

    //         // Anak
    //         'anak.nama' => 'required|string|max:255',
    //         'anak.nik' => 'required|digits:16',
    //         'anak.tempat_lahir' => 'required|string|max:255',
    //         'anak.tanggal_lahir' => 'required|date',
    //         'anak.status_perkawinan' => 'required|string|max:20',
    //         'anak.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //         'anak.pekerjaan' => 'required|string|max:255',
    //         'anak.alamat' => 'required|string',

    //         // Orang Tua
    //         'ortu.nama' => 'required|string|max:255',
    //         'ortu.nik' => 'required|digits:16',
    //         'ortu.tempat_lahir' => 'required|string|max:255',
    //         'ortu.tanggal_lahir' => 'required|date',
    //         'ortu.status_perkawinan' => 'required|string|max:20',
    //         'ortu.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //         'ortu.pekerjaan' => 'required|string|max:255',
    //         'ortu.alamat' => 'required|string',

    //         // Tanggung Jawab
    //         'tanggung_jawab' => 'required|array|min:1',
    //         'tanggung_jawab.*.nama' => 'required|string|max:255',
    //         'tanggung_jawab.*.umur' => 'required|integer|min:0',
    //         'tanggung_jawab.*.pekerjaan' => 'required|string|max:100',
    //         'tanggung_jawab.*.keterangan' => 'required|string|max:255',
    //     ]);

    //     try {
    //         // Ambil jenis surat SKTM
    //         $jenisSurat = JenisSurat::where('kode_surat', 'SKTM')->first();

    //         if (!$jenisSurat) {
    //             return redirect()->back()->with('error', 'Jenis surat SKTM tidak ditemukan.');
    //         }

    //         // SOLUSI: Buat verifikasi dummy untuk admin atau gunakan verifikasi yang sudah ada
    //         // Opsi 1: Cari verifikasi pengguna admin yang sedang login
    //         $verifikasiPengguna = Auth::user()->verifikasi;

    //         // Opsi 2: Jika admin tidak punya verifikasi, buat verifikasi dummy atau gunakan ID default
    //         if (!$verifikasiPengguna) {
    //             // Cari verifikasi pengguna yang sudah terverifikasi (sebagai default)
    //             $verifikasiPengguna = \App\Models\VerifikasiPengguna::where('status', 'Diterima')->first();

    //             // Jika masih tidak ada, buat verifikasi untuk admin
    //             if (!$verifikasiPengguna) {
    //                 $verifikasiPengguna = \App\Models\VerifikasiPengguna::create([
    //                     'user_id' => Auth::id(),
    //                     'nama_lengkap' => Auth::user()->name ?? 'Admin System',
    //                     'nik' => '0000000000000000', // NIK dummy untuk admin
    //                     'tempat_lahir' => 'System',
    //                     'tanggal_lahir' => '1990-01-01',
    //                     'jenis_kelamin' => 'Laki-laki',
    //                     'alamat' => 'System Admin',
    //                     'no_telepon' => '000000000000',
    //                     'pekerjaan' => 'Administrator',
    //                     'foto_ktp' => null,
    //                     'foto_kk' => null,
    //                     'status' => 'verified',
    //                     'tanggal_verifikasi' => now(),
    //                     'keterangan' => 'Auto-generated for admin system'
    //                 ]);
    //             }
    //         }

    //         // Format kapitalisasi
    //         $keperluan = ucfirst(strtolower($request->keperluan));

    //         // Anak
    //         $anak = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->anak);

    //         // Orang tua
    //         $ortu = array_map(fn($v) => is_string($v) ? ucwords(strtolower($v)) : $v, $request->ortu);

    //         // Simpan ke permintaan_surat dengan verifikasi_pengguna_id yang valid
    //         $permintaan = PermintaanSurat::create([
    //             'tanggal_permintaan' => now(),
    //             'status' => 'Diterima', // Langsung diterima karena dibuat admin
    //             'jenis_surat_id' => $jenisSurat->id,
    //             'verifikasi_pengguna_id' => $verifikasiPengguna->id, // Gunakan ID verifikasi yang valid
    //         ]);

    //         // Simpan surat SKTM
    //         $surat = SuratKeteranganTidakMampu::create([
    //             'permintaan_surat_id' => $permintaan->id,
    //             'keperluan' => $keperluan,

    //             // Anak
    //             'anak_nama' => $anak['nama'],
    //             'anak_nik' => $anak['nik'],
    //             'anak_tempat_lahir' => $anak['tempat_lahir'],
    //             'anak_tanggal_lahir' => $anak['tanggal_lahir'],
    //             'anak_status_perkawinan' => $anak['status_perkawinan'],
    //             'anak_jenis_kelamin' => $anak['jenis_kelamin'],
    //             'anak_pekerjaan' => $anak['pekerjaan'],
    //             'anak_alamat' => $anak['alamat'],

    //             // Orang Tua
    //             'ortu_nama' => $ortu['nama'],
    //             'ortu_nik' => $ortu['nik'],
    //             'ortu_tempat_lahir' => $ortu['tempat_lahir'],
    //             'ortu_tanggal_lahir' => $ortu['tanggal_lahir'],
    //             'ortu_status_perkawinan' => $ortu['status_perkawinan'],
    //             'ortu_jenis_kelamin' => $ortu['jenis_kelamin'],
    //             'ortu_pekerjaan' => $ortu['pekerjaan'],
    //             'ortu_alamat' => $ortu['alamat'],
    //         ]);

    //         // Simpan anggota tanggung jawab
    //         foreach ($validated['tanggung_jawab'] as $tj) {
    //             $surat->tanggungJawab()->create([
    //                 'nama' => ucwords(strtolower($tj['nama'])),
    //                 'umur' => $tj['umur'],
    //                 'pekerjaan' => ucwords(strtolower($tj['pekerjaan'])),
    //                 'keterangan' => ucfirst(strtolower($tj['keterangan'])),
    //             ]);
    //         }

    //         // Langsung buat surat terbit karena dibuat oleh admin
    //         $this->createSuratTerbit($permintaan, $surat);

    //         return redirect()->route('sktm.index')->with('success', 'Surat Keterangan Tidak Mampu berhasil dibuat dan siap untuk diterbitkan.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    //     }
    // }
}
