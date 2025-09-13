<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CekVerifikasiPengguna
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = Auth::user();

            // Jika belum login, redirect ke login
            if (! $user) {
                return redirect()->route('login');
            }

            // Log info user dan data verifikasi (untuk debugging)
            Log::info('Middleware CekVerifikasiPengguna:', [
                'user_id' => $user->id,
                'verifikasi' => $user->verifikasi ? $user->verifikasi->toArray() : 'no verifikasi',
            ]);

            // Jika user punya role masyarakat, cek status verifikasinya
            if ($user->hasRole('masyarakat')) {
                if (! $user->verifikasi || $user->verifikasi->status !== 'verified') {
                    return redirect()->route('form.verifikasi')
                        ->with('warning', 'Akun Anda belum diverifikasi.');
                }
            }

            // Jika lolos semua cek, lanjut request berikutnya
            return $next($request);
        } catch (\Exception $e) {
            // Log error agar mudah tracing bug
            Log::error('Error in CekVerifikasiPengguna middleware: '.$e->getMessage());

            // Redirect ke halaman verifikasi dengan pesan error
            return redirect()->route('form.verifikasi')
                ->with('error', 'Terjadi kesalahan saat memeriksa status verifikasi. Silakan coba lagi.');
        }
    }
}
