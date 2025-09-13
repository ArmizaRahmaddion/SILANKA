<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiPengguna;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VerifikasiPenggunaController extends Controller
{

    /**
     * Fonnte service instance
     */
    protected FonnteService $fonnteService;

    /**
     * Constructor
     */
    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

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
                $filename = uniqid('ktp_') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/ktp'), $filename); // Simpan ke public/storage/ktp
                $path = 'ktp/' . $filename;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([
                    'foto_ktp' => 'Gagal menyimpan file: ' . $e->getMessage(),
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
                'error' => 'Gagal menyimpan data ke database: ' . $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function tolak(Request $request, $id): RedirectResponse
    {
        $pesan = $request->pesan_penolakan;

        $user = VerifikasiPengguna::findOrFail($id);

        $devices = $this->checkAccountToken();
        $activeDevice = $devices->first(function ($device) {
            $status = strtolower($device->status);
            return ! in_array($status, ['disconnect', 'disconnected', 'offline']);
        });

        if (! $activeDevice) {
            return redirect()->back()->withErrors([
                'fonnte' => 'Tidak ada device Fonnte yang sedang terhubung.',
            ]);
        }

        $nomor = $user->nomor_hp;
        if (substr($nomor, 0, 2) === '08') {
            $nomor = '62' . substr($nomor, 1);
        }

        // Kirim pesan ke WhatsApp via Fonnte
        $response = Http::withHeaders([
            'Authorization' => $activeDevice->token,
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

    public function terima(int $id): RedirectResponse
    {
        $user = VerifikasiPengguna::findOrFail($id);

        $devices = $this->checkAccountToken();
        $activeDevice = $devices->first(function ($device) {
            $status = strtolower($device->status);
            return ! in_array($status, ['disconnect', 'disconnected', 'offline']);
        });

        if (! $activeDevice) {
            return redirect()->back()->withErrors([
                'fonnte' => 'Tidak ada device Fonnte yang sedang terhubung.',
            ]);
        }

        $nomor = $user->nomor_hp;
        if (substr($nomor, 0, 2) === '08') {
            $nomor = '62' . substr($nomor, 1);
        }

        $response = Http::withHeaders([
            'Authorization' => $activeDevice->token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => "Halo $user->nama_lengkap, verifikasi akun kamu telah diterima. Sekarang kamu bisa mengakses layanan surat dan pengaduan.",
        ]);

        if (! $response->ok()) {
            return redirect()->back()->withErrors([
                'fonnte' => 'Gagal mengirim WhatsApp melalui Fonnte.',
            ]);
        }

        $user->status = 'verified';
        $user->save();

        return redirect()->back()->with('success', 'Verifikasi berhasil dan notifikasi WhatsApp sudah dikirim.');
    }

    protected function checkAccountToken(): Collection
    {
        $apiResponse = $this->fonnteService->getAllDevices();

        $devices = collect();
        if (($apiResponse['status'] ?? false) && isset($apiResponse['data']['data'])) {
            $devices = collect($apiResponse['data']['data'])->map(function ($device) {
                return (object) [
                    'id' => $device['token'] ?? '',
                    'name' => $device['name'] ?? 'Unknown Device',
                    'token' => $device['token'] ?? '',
                    'device' => $device['device'] ?? '',
                    'is_active' => $this->mapAPIStatusToLocal($device['status'] ?? 'unknown'),
                    'status' => $device['status'] ?? 'unknown',
                    'device_info' => $device['device_info'] ?? null,
                    'created_at' => now(),
                ];
            });
        }

        return $devices;
    }

    protected function mapAPIStatusToLocal(?string $status): bool
    {
        if ($status === null) {
            return false;
        }

        $normalized = strtolower($status);

        if (in_array($normalized, ['disconnect', 'disconnected', 'offline', 'not connected', 'qr', 'waiting'], true)) {
            return false;
        }

        return in_array($normalized, ['connected', 'online', 'ready'], true);
    }
}
