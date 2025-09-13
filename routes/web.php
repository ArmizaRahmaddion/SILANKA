<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\CekSuratController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisSurat\SuratKeteranganAhliWarisController;
use App\Http\Controllers\JenisSurat\SuratKeteranganDomisiliController;
use App\Http\Controllers\JenisSurat\SuratKeteranganMeniggalDuniaController;
use App\Http\Controllers\JenisSurat\SuratKeteranganTidakMampuController;
use App\Http\Controllers\JenisSurat\SuratKeteranganUsahaController;
use App\Http\Controllers\KategoriKotenController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PerangkatNagariController;
use App\Http\Controllers\PermintaanSuratController;
use App\Http\Controllers\RiwayatSuratController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratTerbitController;
use App\Http\Controllers\VerifikasiPenggunaController;
use App\Http\Controllers\VerifikasiSuratFinalController;
use App\Http\Middleware\CekVerifikasiPengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth & Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('layouts.landing-page.beranda');
});

Auth::routes([
    'password.confirm' => false,
    'password.reset' => false,
    'password.request' => false,
    'password.email' => false,
    'password.update' => false,
]);

Route::get('/chek-surat', [CekSuratController::class, 'checkForm'])->name('surat.check.form');
Route::post('/hasil-check-surat', [CekSuratController::class, 'checkSurat'])->name('surat.check.process');
Route::post('/print/{verifikasiId}', [CekSuratController::class, 'printSuratFromCheck'])->name('surat.print.from.check');

// Berita Routes
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.detail');

Route::get('/perangkat', [MainController::class, 'perangkat'])->name('perangkat');

/*
|--------------------------------------------------------------------------
| Masyarakat Routes (User Role: masyarakat)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:masyarakat|superadmin'])->group(function () {

    // Route::get('/beranda', function () {
    //     return view('layouts.landing-page.beranda');
    // })->name('masyarakat.beranda');

    Route::middleware(CekVerifikasiPengguna::class)->group(function () {

        // Pengaduan
        Route::get('/e-aduan', [PengaduanController::class, 'create'])->name('e-aduan');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

        // E-Surat
        Route::get('/e-surat', [SuratController::class, 'index'])->name('e-surat.index');

        // Riwayat Surat
        Route::get('/riwayat-surat', [RiwayatSuratController::class, 'index'])->name('riwayat-surat.index');
        Route::get('/riwayat-surat/{id}/status', [RiwayatSuratController::class, 'getRiwayatStatus'])->name('riwayat-surat.status');
        Route::get('/riwayat-surat/{id}/detail', [RiwayatSuratController::class, 'getdetailSurat'])->name('riwayat-surat.detail');

        // Form Surat
        Route::get('/surat/skaw', [SuratKeteranganAhliWarisController::class, 'create'])->name('surat.skaw');
        Route::get('/surat/sktm', [SuratKeteranganTidakMampuController::class, 'create'])->name('surat.sktm');

        // SKKM
        Route::get('/surat/skkm', [SuratKeteranganMeniggalDuniaController::class, 'index'])->name('surat.skkm');
        Route::get('/surat/skkm/create', [SuratKeteranganMeniggalDuniaController::class, 'create'])->name('surat.skkm');
        Route::post('/surat/skkm/store', [SuratKeteranganMeniggalDuniaController::class, 'store'])->name('skkm.store');

        // SKD
        Route::get('/surat/skd', [SuratKeteranganDomisiliController::class, 'index'])->name('surat.skd');
        Route::get('/surat/skd/create', [SuratKeteranganDomisiliController::class, 'create'])->name('surat.skd');
        Route::post('/surat/skd/store', [SuratKeteranganDomisiliController::class, 'store'])->name('skd.store');

        // SKU
        Route::get('/surat/sku', [SuratKeteranganUsahaController::class, 'index'])->name('surat.sku');
        Route::get('/surat/sku/create', [SuratKeteranganUsahaController::class, 'create'])->name('surat.sku');
        Route::post('/surat/sku/store', [SuratKeteranganUsahaController::class, 'store'])->name('sku.store');

        //  SKTM
        Route::get('/surat/sktm/create', [SuratKeteranganTidakMampuController::class, 'create'])->name('surat.sktm');
        Route::post('/surat/sktm/store', [SuratKeteranganTidakMampuController::class, 'store'])->name('sktm.store');
    });

    Route::get('/verifikasi', [VerifikasiPenggunaController::class, 'formVerifikasiforSurat'])->name('form.verifikasi');
    Route::post('/verifikasi', [VerifikasiPenggunaController::class, 'submit'])->name('form.verifikasi.submit');

    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    // Route::get('/perangkat', [MainController::class, 'perangkat'])->name('perangkat');
});

/*
|--------------------------------------------------------------------------
| Admin, Seknag, Staff TU Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:superadmin|seknag|staff-tu'])->group(function () {

    Route::get('/dashboard', function () {
        $totalPengaduan = \App\Models\Pengaduan::count();
        $totalUsers = \App\Models\User::count();
        $totalPerangkatNagari = \App\Models\PerangkatNagari::count();
        $totalPermintaanSuratHariIni = \App\Models\PermintaanSurat::whereDate('created_at', now()->toDateString())->count();

        return view('home', compact(
            'totalPengaduan',
            'totalUsers',
            'totalPerangkatNagari',
            'totalPermintaanSuratHariIni',
        ));
    })->name('dashboard');

    // Verifikasi Pengguna
    Route::get('/admin/verifikasi-pengguna', [VerifikasiPenggunaController::class, 'index'])->name('verifikasi.pengguna');
    Route::post('/verifikasi/tolak/{id}', [VerifikasiPenggunaController::class, 'tolak'])->name('verifikasi.tolak');
    Route::post('/verifikasi/terima/{id}', [VerifikasiPenggunaController::class, 'terima'])->name('verifikasi.terima');

    // Data Pengguna & Perangkat Nagari
    Route::get('/admin/data-pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/admin/perangkat-nagari', [PerangkatNagariController::class, 'index'])->name('perangkat.index');
    Route::post('/admin/perangkat-nagari/store', [PerangkatNagariController::class, 'store'])->name('perangkat.store');
    Route::put('/admin/perangkat-nagari/{id}', [PerangkatNagariController::class, 'update'])->name('perangkat.update');
    Route::delete('/admin/perangkat-nagari/{id}', [PerangkatNagariController::class, 'destroy'])->name('perangkat.destroy');

    // SKKM
    Route::get('/skkm', [SuratKeteranganMeniggalDuniaController::class, 'index'])->name('skkm.index');
    Route::get('/skkm/create', [SuratKeteranganMeniggalDuniaController::class, 'create'])->name('create');
    Route::post('/skkm/store', [SuratKeteranganMeniggalDuniaController::class, 'store'])->name('store');
    Route::put('/surat/skkm/{id}/update', [SuratKeteranganMeniggalDuniaController::class, 'update'])->name('surat.skkm.update');
    Route::get('/skkm/{id}/print', [SuratKeteranganMeniggalDuniaController::class, 'print'])->name('skkm.print');
    Route::get('/skkm/{id}/preview', [SuratKeteranganMeniggalDuniaController::class, 'preview'])->name('skkm.preview');
    Route::get('/skkm/preview/{id}', [SuratKeteranganMeniggalDuniaController::class, 'redirectPreview'])->name('surat.skkm.preview');
    Route::get('/skkm/verifikasi/preview/{id}', [SuratKeteranganMeniggalDuniaController::class, 'previewVerified'])->name('verifikasi.skkm.preview');

    // SKD
    Route::get('/skd', [SuratKeteranganDomisiliController::class, 'index'])->name('skd.index');
    Route::put('/surat/skd/{id}/update', [SuratKeteranganDomisiliController::class, 'update'])->name('surat.skd.update');
    Route::get('/skd/{id}/print', [SuratKeteranganDomisiliController::class, 'print'])->name('skd.print');
    Route::get('/skd/{id}/preview', [SuratKeteranganDomisiliController::class, 'preview'])->name('skd.preview');
    Route::post('/{id}/ajukan-ttd', [SuratKeteranganDomisiliController::class, 'ajukanTtd'])->name('ajukan.ttd');
    Route::get('/skd/preview/{id}', [SuratKeteranganDomisiliController::class, 'redirectPreview'])->name('surat.skd.preview');
    Route::get('/skd/verifikasi/preview/{id}', [SuratKeteranganDomisiliController::class, 'previewVerified'])->name('verifikasi.skd.preview');

    // SKU
    Route::get('/sku', [SuratKeteranganUsahaController::class, 'index'])->name('sku.index');
    Route::put('/surat/sku/{id}/update', [SuratKeteranganUsahaController::class, 'update'])->name('surat.sku.update');
    Route::get('/sku/{id}/print', [SuratKeteranganUsahaController::class, 'print'])->name('sku.print');
    Route::get('/sku/{id}/preview', [SuratKeteranganUsahaController::class, 'preview'])->name('sku.preview');
    Route::get('/sku/preview/{id}', [SuratKeteranganUsahaController::class, 'redirectPreview'])->name('surat.sku.preview');
    Route::get('/sku/verifikasi/preview/{id}', [SuratKeteranganUsahaController::class, 'previewVerified'])->name('verifikasi.sku.preview');

    //  SKTM
    Route::get('/sktm', [SuratKeteranganTidakMampuController::class, 'index'])->name('sktm.index');
    // Route::post('/sktm/store-admin', [SuratKeteranganTidakMampuController::class, 'storeFromAdmin'])->name('sktm.store.admin');
    Route::put('/surat/sktm{id}/update', [SuratKeteranganTidakMampuController::class, 'update'])->name('surat.sktm.update');
    Route::get('/sktm/{id}/print', [SuratKeteranganTidakMampuController::class, 'print'])->name('sktm.print');
    Route::get('/sktm/{id}/preview', [SuratKeteranganTidakMampuController::class, 'preview'])->name('sktm.preview');
    Route::get('/sktm/preview/{id}', [SuratKeteranganTidakMampuController::class, 'redirectPreview'])->name('surat.sktm.preview');
    Route::get('/sktm/verifikasi/preview/{id}', [SuratKeteranganTidakMampuController::class, 'previewVerified'])->name('verifikasi.sktm.preview');

    // Verifikasi Surat Final
    Route::get('/verifikasi-surat', [VerifikasiSuratFinalController::class, 'finalIndex'])->name('verifikasi.index');
    Route::post('/{id}/verifikasi', [VerifikasiSuratFinalController::class, 'verifikasi'])->name('process');
    Route::get('/verified', [VerifikasiSuratFinalController::class, 'verifiedIndex'])->name('verifikasi.verified');
    Route::get('/preview-verified/{id}', [VerifikasiSuratFinalController::class, 'previewVerifiedFromList'])->name('verifikasi.preview.verified');
    Route::post('/{kodeSurat}/{id}/ajukan-ttd', [VerifikasiSuratFinalController::class, 'ajukanTtd'])->name('ajukan.ttd');

    // Surat Terbit
    Route::get('/permintaan-surat', [PermintaanSuratController::class, 'index'])->name('permintaan.surat');
    Route::get('/permintaan-surat/{id}/buat-surat', [SuratTerbitController::class, 'showBuatSurat'])->name('permintaan-surat.buat-surat');
    Route::post('/permintaan-surat/{id}/simpan-surat', [SuratTerbitController::class, 'simpanSurat'])->name('permintaan-surat.simpan-surat');

    // Pengaduan Admin
    Route::get('/admin/e-aduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/admin/e-aduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Kategori Berita
    Route::controller(KategoriKotenController::class)->prefix('kategori-konten')->group(function () {
        Route::get('/list', 'index')->name('kategori-koten.index');
        Route::post('/store', 'store')->name('kategori-koten.store');
        Route::put('/{kategoriKoten}', 'update')->name('kategori-koten.update');
        Route::delete('/{kategoriKoten}', 'destroy')->name('kategori-koten.destroy');
    });

    // Manajemen Konten
    Route::resource('konten', KontenController::class);
    Route::patch('/konten/{konten}/status', [KontenController::class, 'updateStatus'])->name('konten.updateStatus');

    // Manajemen WhatsApp Gateway - Fonnte (API Only)
    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [App\Http\Controllers\DeviceFonnteController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\DeviceFonnteController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\DeviceFonnteController::class, 'store'])->name('store');

        // Device actions using token
        Route::get('/{token}', [App\Http\Controllers\DeviceFonnteController::class, 'show'])->name('show');
        Route::delete('/{token}', [App\Http\Controllers\DeviceFonnteController::class, 'destroy'])->name('destroy');
        Route::post('/{token}/activate', [App\Http\Controllers\DeviceFonnteController::class, 'activateDevice'])->name('activate');
        Route::post('/{token}/disconnect', [App\Http\Controllers\DeviceFonnteController::class, 'disconnect'])->name('disconnect');
        Route::get('/{token}/status', [App\Http\Controllers\DeviceFonnteController::class, 'checkDeviceStatus'])->name('status');

        // Send message
        Route::post('/send-message', [App\Http\Controllers\DeviceFonnteController::class, 'sendTestMessage'])->name('send-message');

        // API test connection
        Route::get('/test/connection', [App\Http\Controllers\DeviceFonnteController::class, 'testConnection'])->name('test.connection');
    });

    // API Routes for messaging (can be accessed by external apps)
    Route::post('/api/send-message', [App\Http\Controllers\DeviceFonnteController::class, 'sendMessage'])->name('api.send-message');
});
