<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VerifikasiPenggunaController extends Controller
{
    public function index()
    {
        // Ambil pengguna yang belum diverifikasi, misalnya berdasarkan kolom 'is_verified'
        $users = VerifikasiPengguna::where('status', 'pending')->get();

        return view('layouts.admin.verifikasi-pengguna-list', compact('users'));
    }

    public function formVerifikasiforSurat()
    {
        $verifikasi = Auth::user()->verifikasi;
        if ($verifikasi && $verifikasi->status === 'verified') {
            // dd(Auth::user()->verifikasi);

            return redirect()->route('e-surat.index');
        }

        return view('layouts.landing-page.verifikasi-pengguna.form-verifikasi', compact('verifikasi'));
    }

    public function formVerifikasiforPengaduan()
    {
        $verifikasi = Auth::user()->verifikasi;
        if ($verifikasi && $verifikasi->status === 'verified') {
            // dd(Auth::user()->verifikasi);
            return redirect()->route('e-aduan');
        }

        return view('layouts.landing-page.verifikasi-pengguna.form-verifikasi', compact('verifikasi'));
    }

    public function submit(Request $request)
    {
        $verifikasi = VerifikasiPengguna::where('user_id', Auth::id())->first();

        // Aturan validasi
        $rules = [
            'nik' => 'required|min:1|max:16',
            'nama_lengkap' => 'required|string',
            'nomor_hp' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
        ];

        // Wajib upload foto jika belum pernah atau sedang revisi
        if (! $verifikasi || ! $verifikasi->foto_ktp || $request->hasFile('foto_ktp')) {
            $rules['foto_ktp'] = 'required|image|max:20480'; // 20MB
        }

        $request->validate($rules);

        $path = $verifikasi->foto_ktp ?? null;

        // Upload file manual (tanpa store)
        if ($request->hasFile('foto_ktp')) {
            $file = $request->file('foto_ktp');

            if (! $file->isValid()) {
                return redirect()->back()->withErrors([
                    'foto_ktp' => 'File upload tidak valid.',
                ]);
            }

            try {
                $filename = uniqid('ktp_').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('storage/ktp'), $filename); // Simpan ke public/storage/ktp
                $path = 'ktp/'.$filename;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([
                    'foto_ktp' => 'Gagal menyimpan file: '.$e->getMessage(),
                ]);
            }
        }

        try {
            VerifikasiPengguna::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'nik' => $request->nik,
                    'nama_lengkap' => $request->nama_lengkap,
                    'nomor_hp' => $request->nomor_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'foto_ktp' => $path,
                    'status' => 'pending',
                ]
            );
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Gagal menyimpan data ke database: '.$e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function tolak(Request $request, $id)
    {
        $user = VerifikasiPengguna::findOrFail($id);
        $pesan = $request->pesan_penolakan;

        // Ubah nomor HP ke format internasional (08 → 62)
        $nomor = $user->nomor_hp;
        if (substr($nomor, 0, 2) == '08') {
            $nomor = '62'.substr($nomor, 1);
        }

        // Kirim pesan ke WhatsApp via Fonnte
        Http::withHeaders([
            'Authorization' => '5fdfLNzPGCRgsn5B5FiD', // Token Fonnte kamu
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => "Halo $user->nama_lengkap, verifikasi akun kamu ditolak.\n\nCatatan: $pesan\n\nSilakan lengkapi data kamu dan ajukan ulang.",
        ]);

        // Update status atau logika penolakan lainnya di database
        $user->status = 'rejected';
        $user->pesan_penolakan = $pesan;
        $user->save();

        return redirect()->back()->with('success', 'Penolakan berhasil dikirim dan dikabari ke WhatsApp.');
    }

    public function terima(Request $request, $id)
    {
        $user = VerifikasiPengguna::findOrFail($id);

        // Ubah nomor HP ke format internasional (08 → 62)
        $nomor = $user->nomor_hp;
        if (substr($nomor, 0, 2) == '08') {
            $nomor = '62'.substr($nomor, 1);
        }

        // Kirim pesan ke WhatsApp via Fonnte
        Http::withHeaders([
            'Authorization' => '5fdfLNzPGCRgsn5B5FiD', // Token Fonnte kamu
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => "Halo $user->nama_lengkap, verifikasi akun kamu telah diterima. Sekarang kamu bisa mengaskes layanan surat dan pengaduan.",
        ]);

        // Update status
        $user->status = 'verified';
        $user->save();

        return redirect()->back()->with('success', 'Verifikasi berhasil dikirim dan dikabari ke WhatsApp.');
    }
}
