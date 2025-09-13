@extends('layouts.landing-page.layout')

@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>VERIFIKASI DATA DIRI</h1>
                            @if ($verifikasi && $verifikasi->status !== 'verified')
                                <div class="alert alert-warning">
                                    <strong>Catatan:</strong> Akun Anda belum terverifikasi.
                                    Untuk dapat mengakses fitur seperti <em>Pengaduan</em> dan <em>Pengajuan Surat</em>,
                                    Anda harus menunggu hingga proses verifikasi selesai, Segala informasi akan kami
                                    kabarkan via Whatsapp.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="current">Verifikasi Data Diri</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Team Section -->
        <section id="form-verifikasi" class="section py-4">
            <div class="container">

                @php
                    $locked = $verifikasi && in_array($verifikasi->status, ['pending', 'verified']);
                    $statusMap = [
                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'warning'],
                        'verified' => ['label' => 'Terverifikasi', 'class' => 'success'],
                        'rejected' => ['label' => 'Ditolak - Perlu Perbaikan', 'class' => 'danger'],
                    ];
                @endphp

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="fw-semibold mb-2">Periksa kembali isian Anda:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <div class="card shadow-sm border-0">
                            <div
                                class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0 fw-semibold">Formulir Verifikasi Penduduk</h5>
                                @if ($verifikasi)
                                    <span class="badge bg-{{ $statusMap[$verifikasi->status]['class'] ?? 'secondary' }}">
                                        {{ $statusMap[$verifikasi->status]['label'] ?? Str::ucfirst($verifikasi->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-info">Belum Diajukan</span>
                                @endif
                            </div>
                            <div class="card-body">

                                <p class="text-muted small mb-4">
                                    Lengkapi data berikut dengan benar sesuai KTP. Data ini digunakan untuk pelayanan surat
                                    dan pengaduan masyarakat. Kolom bertanda (*) wajib diisi.
                                </p>

                                <form method="POST" action="{{ route('form.verifikasi.submit') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="nik" class="form-label fw-semibold">NIK <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" inputmode="numeric" pattern="\d{16}" maxlength="16"
                                                class="form-control @error('nik') is-invalid @enderror" id="nik"
                                                name="nik" placeholder="16 digit sesuai KTP"
                                                value="{{ old('nik', $verifikasi->nik ?? '') }}"
                                                {{ $locked ? 'disabled' : '' }}>
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="form-text">Pastikan 16 digit sesuai KTP.</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                id="nama_lengkap" name="nama_lengkap" placeholder="Sesuai nama di KTP"
                                                value="{{ old('nama_lengkap', $verifikasi->nama_lengkap ?? '') }}"
                                                {{ $locked ? 'disabled' : '' }}>
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nomor_hp" class="form-label fw-semibold">Nomor HP (WA Aktif) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp"
                                                name="nomor_hp" placeholder="08xxxxxxxxxx"
                                                value="{{ old('nomor_hp', $verifikasi->nomor_hp ?? '') }}"
                                                {{ $locked ? 'disabled' : '' }}>
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="form-text">Digunakan untuk pemberitahuan verifikasi.</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span
                                                    class="text-danger">*</span></label>
                                            <select id="jenis_kelamin" name="jenis_kelamin"
                                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                {{ $locked ? 'disabled' : '' }}>
                                                <option value="L"
                                                    {{ old('jenis_kelamin', $verifikasi->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="P"
                                                    {{ old('jenis_kelamin', $verifikasi->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold d-block">Foto KTP <span
                                                    class="text-danger">*</span></label>

                                            @if ($verifikasi && $verifikasi->foto_ktp)
                                                <div class="row g-3 align-items-start">
                                                    <div class="col-auto">
                                                        <div class="small text-muted mb-1">Tersimpan:</div>
                                                        <div class="preview-ktp-box">
                                                            <img src="{{ Storage::url($verifikasi->foto_ktp) }}"
                                                                alt="Foto KTP Tersimpan">
                                                            <span class="preview-ktp-label">Lama</span>
                                                        </div>
                                                    </div>
                                                    @if (!$locked)
                                                        <div class="col">
                                                            <label class="form-label small mb-1">Ubah Foto KTP (jika
                                                                perlu)</label>
                                                            <input type="file" name="foto_ktp" id="foto_ktp_input"
                                                                class="form-control @error('foto_ktp') is-invalid @enderror"
                                                                accept="image/*">
                                                            @error('foto_ktp')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @else
                                                                <div class="form-text">Format: JPG/PNG, jelas & tidak blur.
                                                                </div>
                                                            @enderror

                                                            <div class="mt-3 d-none" id="preview_wrapper_new">
                                                                <div class="small text-muted mb-1">Pratinjau Baru:</div>
                                                                <div class="preview-ktp-box" id="preview_box_new">
                                                                    <span id="preview_placeholder_new">Belum ada
                                                                        gambar</span>
                                                                    <span class="preview-ktp-label">Baru</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="row g-3">
                                                    <div class="col-md-6 col-lg-8">
                                                        <input type="file" name="foto_ktp" id="foto_ktp_input"
                                                            class="form-control @error('foto_ktp') is-invalid @enderror"
                                                            accept="image/*">
                                                        @error('foto_ktp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @else
                                                            <div class="form-text">Unggah foto KTP yang jelas (JPG/PNG).</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="small text-muted mb-1">Pratinjau:</div>
                                                        <div class="preview-ktp-box" id="preview_box_new">
                                                            <span id="preview_placeholder_new">Belum ada gambar</span>
                                                            <span class="preview-ktp-label">Preview</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top">
                                        <div class="small text-muted">
                                            @if ($verifikasi && $verifikasi->status === 'rejected')
                                                Perbaiki data lalu kirim ulang.
                                            @elseif ($locked)
                                                Data terkunci selama proses verifikasi.
                                            @else
                                                Pastikan seluruh data benar sebelum mengirim.
                                            @endif
                                        </div>
                                        @if (!$verifikasi || ($verifikasi && $verifikasi->status === 'rejected'))
                                            <button type="submit" class="btn btn-primary px-4">
                                                {{ $verifikasi ? 'Kirim Ulang' : 'Kirim' }}
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer bg-light small text-muted">
                                Layanan Verifikasi Penduduk - Sistem Pelayanan Desa
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <style>
                .preview-ktp-box {
                    width: 240px;
                    aspect-ratio: 1.586 / 1;
                    /* Rasio kira-kira KTP */
                    border: 1px dashed #ced4da;
                    border-radius: .5rem;
                    background: #f8f9fa;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    position: relative;
                    font-size: .75rem;
                    color: #6c757d;
                    text-align: center;
                    padding: .25rem;
                }

                .preview-ktp-box img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    display: block;
                }

                .preview-ktp-label {
                    font-size: .7rem;
                    position: absolute;
                    bottom: 2px;
                    right: 6px;
                    background: rgba(0, 0, 0, .5);
                    color: #fff;
                    padding: 2px 6px;
                    border-radius: 10px;
                    line-height: 1;
                    letter-spacing: .5px;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('foto_ktp_input');
                    if (!input) {
                        return;
                    }

                    let currentObjectUrl = null;
                    const wrapper = document.getElementById('preview_wrapper_new');
                    const box = document.getElementById('preview_box_new');
                    const placeholder = document.getElementById('preview_placeholder_new');

                    function clearPreview() {
                        if (currentObjectUrl) {
                            URL.revokeObjectURL(currentObjectUrl);
                            currentObjectUrl = null;
                        }
                        if (box) {
                            box.innerHTML = '';
                            box.appendChild(placeholder);
                            placeholder.classList.remove('d-none');
                        }
                    }

                    input.addEventListener('change', function(e) {
                        const file = e.target.files && e.target.files[0] ? e.target.files[0] : null;

                        if (!file) {
                            clearPreview();
                            return;
                        }

                        if (!file.type.startsWith('image/')) {
                            clearPreview();
                            return;
                        }

                        if (wrapper && wrapper.classList.contains('d-none')) {
                            wrapper.classList.remove('d-none');
                        }

                        if (currentObjectUrl) {
                            URL.revokeObjectURL(currentObjectUrl);
                        }

                        currentObjectUrl = URL.createObjectURL(file);

                        if (box) {
                            box.innerHTML = '';
                            const img = document.createElement('img');
                            img.src = currentObjectUrl;
                            img.alt = 'Preview Foto KTP';
                            box.appendChild(img);

                            const badge = document.createElement('span');
                            badge.className = 'preview-ktp-label';
                            badge.textContent = 'Baru';
                            box.appendChild(badge);
                        }
                    });
                });
            </script>
        </section>
        <!-- /Team Section -->
    </main>
@endsection
