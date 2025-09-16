@extends('layouts.landing-page.layout')
@section('content')
    <!-- Modern Page Header -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        <h1 class="text-white mb-3">
                            <i class="bi bi-people me-3"></i>
                            Formulir Surat Keterangan Tidak Mampu
                        </h1>
                        <p class="text-white-50 mb-0 fs-5">
                            Lengkapi data di bawah ini untuk mengajukan surat keterangan tidak mampu
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Form Section -->
    <section id="form-sktm" class="py-5 bg-light">
        <div class="container">
            <!-- Main Form Card -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-header bg-white border-0 py-4">
                            <h4 class="card-title text-center mb-0">
                                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                                Form Pengajuan Surat Keterangan Tidak Mampu
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('sktm.store') }}" method="POST" id="sktmForm">
                                @csrf

                                <!-- Section 1: Info Pengajuan -->
                                <div class="form-section mb-5">
                                    <div class="section-header mb-4">
                                        <h5 class="text-primary fw-bold mb-2">
                                            <i class="bi bi-clipboard-check me-2"></i>
                                            Informasi Pengajuan
                                        </h5>
                                        <hr class="border-primary opacity-25">
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan"
                                                    class="form-control" value="{{ date('Y-m-d') }}" disabled>
                                                <label for="tanggal_pengajuan">
                                                    <i class="bi bi-calendar-check me-2"></i>Tanggal Pengajuan
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="keperluan" id="keperluan" class="form-control"
                                                    placeholder="Contoh: Beasiswa pendidikan" required
                                                    value="{{ old('keperluan') }}">
                                                <label for="keperluan">
                                                    <i class="bi bi-clipboard-check me-2"></i>Keperluan *
                                                </label>
                                                <div class="form-text">
                                                    <small class="text-muted">
                                                        <i class="bi bi-lightbulb me-1"></i>
                                                        Jelaskan untuk apa surat ini digunakan
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Data Pemohon -->
                                <div class="form-section mb-5">
                                    <div class="section-header mb-4">
                                        <h5 class="text-primary fw-bold mb-2">
                                            <i class="bi bi-person-circle me-2"></i>
                                            Data Pemohon
                                        </h5>
                                        <hr class="border-primary opacity-25">
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="anak[nama]" id="anak_nama" class="form-control"
                                                    placeholder="Masukkan nama lengkap" required
                                                    value="{{ old('anak.nama') }}">
                                                <label for="anak_nama">
                                                    <i class="bi bi-person me-2"></i>Nama Lengkap *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="anak[nik]" id="anak_nik" maxlength="16"
                                                    class="form-control" placeholder="Masukkan 16 digit NIK" required
                                                    value="{{ old('anak.nik') }}">
                                                <label for="anak_nik">
                                                    <i class="bi bi-credit-card me-2"></i>Nomor Induk Kependudukan (NIK) *
                                                </label>
                                                <div class="form-text">
                                                    <small class="text-muted">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Masukkan 16 digit NIK sesuai KTP
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="anak[tempat_lahir]" id="anak_tempat_lahir"
                                                    class="form-control" placeholder="Masukkan tempat lahir" required
                                                    value="{{ old('anak.tempat_lahir') }}">
                                                <label for="anak_tempat_lahir">
                                                    <i class="bi bi-geo-alt me-2"></i>Tempat Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="anak[tanggal_lahir]" id="anak_tanggal_lahir"
                                                    class="form-control" required value="{{ old('anak.tanggal_lahir') }}">
                                                <label for="anak_tanggal_lahir">
                                                    <i class="bi bi-calendar me-2"></i>Tanggal Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="anak[jenis_kelamin]" id="anak_jenis_kelamin"
                                                    class="form-select" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki"
                                                        {{ old('anak.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        {{ old('anak.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                <label for="anak_jenis_kelamin">
                                                    <i class="bi bi-gender-ambiguous me-2"></i>Jenis Kelamin *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="anak[pekerjaan]" id="anak_pekerjaan"
                                                    class="form-control" placeholder="Masukkan pekerjaan" required
                                                    value="{{ old('anak.pekerjaan') }}">
                                                <label for="anak_pekerjaan">
                                                    <i class="bi bi-briefcase me-2"></i>Pekerjaan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="anak[status_perkawinan]" id="anak_status_perkawinan"
                                                    class="form-select" required>
                                                    <option value="">Pilih Status Perkawinan</option>
                                                    @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                                        <option value="{{ $status }}"
                                                            {{ old('anak.status_perkawinan') == $status ? 'selected' : '' }}>
                                                            {{ $status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="anak_status_perkawinan">
                                                    <i class="bi bi-heart me-2"></i>Status Perkawinan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <textarea name="anak[alamat]" id="anak_alamat" class="form-control" style="height: 100px;"
                                                    placeholder="Masukkan alamat lengkap" required>{{ old('anak.alamat') }}</textarea>
                                                <label for="anak_alamat">
                                                    <i class="bi bi-house me-2"></i>Alamat *
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Data Orang Tua -->
                                <div class="form-section mb-5">
                                    <div class="section-header mb-4">
                                        <h5 class="text-primary fw-bold mb-2">
                                            <i class="bi bi-people me-2"></i>
                                            Data Orang Tua
                                        </h5>
                                        <hr class="border-primary opacity-25">
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="ortu[nama]" id="ortu_nama"
                                                    class="form-control" placeholder="Masukkan nama lengkap" required
                                                    value="{{ old('ortu.nama') }}">
                                                <label for="ortu_nama">
                                                    <i class="bi bi-person me-2"></i>Nama Lengkap *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="ortu[nik]" id="ortu_nik" maxlength="16"
                                                    class="form-control" placeholder="Masukkan 16 digit NIK" required
                                                    value="{{ old('ortu.nik') }}">
                                                <label for="ortu_nik">
                                                    <i class="bi bi-credit-card me-2"></i>Nomor Induk Kependudukan (NIK) *
                                                </label>
                                                <div class="form-text">
                                                    <small class="text-muted">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Masukkan 16 digit NIK sesuai KTP
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="ortu[tempat_lahir]" id="ortu_tempat_lahir"
                                                    class="form-control" placeholder="Masukkan tempat lahir" required
                                                    value="{{ old('ortu.tempat_lahir') }}">
                                                <label for="ortu_tempat_lahir">
                                                    <i class="bi bi-geo-alt me-2"></i>Tempat Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="ortu[tanggal_lahir]" id="ortu_tanggal_lahir"
                                                    class="form-control" required
                                                    value="{{ old('ortu.tanggal_lahir') }}">
                                                <label for="ortu_tanggal_lahir">
                                                    <i class="bi bi-calendar me-2"></i>Tanggal Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="ortu[jenis_kelamin]" id="ortu_jenis_kelamin"
                                                    class="form-select" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki"
                                                        {{ old('ortu.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        {{ old('ortu.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                <label for="ortu_jenis_kelamin">
                                                    <i class="bi bi-gender-ambiguous me-2"></i>Jenis Kelamin *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="ortu[pekerjaan]" id="ortu_pekerjaan"
                                                    class="form-control" placeholder="Masukkan pekerjaan" required
                                                    value="{{ old('ortu.pekerjaan') }}">
                                                <label for="ortu_pekerjaan">
                                                    <i class="bi bi-briefcase me-2"></i>Pekerjaan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="ortu[status_perkawinan]" id="ortu_status_perkawinan"
                                                    class="form-select" required>
                                                    <option value="">Pilih Status Perkawinan</option>
                                                    @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                                        <option value="{{ $status }}"
                                                            {{ old('ortu.status_perkawinan') == $status ? 'selected' : '' }}>
                                                            {{ $status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="ortu_status_perkawinan">
                                                    <i class="bi bi-heart me-2"></i>Status Perkawinan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <textarea name="ortu[alamat]" id="ortu_alamat" class="form-control" style="height: 100px;"
                                                    placeholder="Masukkan alamat lengkap" required>{{ old('ortu.alamat') }}</textarea>
                                                <label for="ortu_alamat">
                                                    <i class="bi bi-house me-2"></i>Alamat *
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 4: Tanggung Jawab Keluarga -->
                                <div class="form-section mb-5">
                                    <div class="section-header mb-4">
                                        <h5 class="text-primary fw-bold mb-2">
                                            <i class="bi bi-people-fill me-2"></i>
                                            Tanggung Jawab Keluarga
                                        </h5>
                                        <hr class="border-primary opacity-25">
                                        <div class="alert alert-info border-0 rounded-3 mb-3" role="alert">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-info-circle-fill text-info me-3 fs-5"></i>
                                                <div>
                                                    <h6 class="alert-heading fw-bold mb-1">Informasi</h6>
                                                    <p class="mb-0">Tambahkan data anggota keluarga yang menjadi tanggung
                                                        jawab orang tua.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tanggungjawab-wrapper">
                                        <div class="card border-primary bg-light mb-3">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="tanggung_jawab[0][nama]"
                                                                id="tj_nama_0" class="form-control"
                                                                placeholder="Nama anggota keluarga" required>
                                                            <label for="tj_nama_0">
                                                                <i class="bi bi-person me-1"></i>Nama *
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-floating">
                                                            <input type="number" name="tanggung_jawab[0][umur]"
                                                                id="tj_umur_0" class="form-control" placeholder="Umur"
                                                                min="1" max="100" required>
                                                            <label for="tj_umur_0">
                                                                <i class="bi bi-calendar-date me-1"></i>Umur *
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="tanggung_jawab[0][pekerjaan]"
                                                                id="tj_pekerjaan_0" class="form-control"
                                                                placeholder="Pekerjaan" required>
                                                            <label for="tj_pekerjaan_0">
                                                                <i class="bi bi-briefcase me-1"></i>Pekerjaan *
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="tanggung_jawab[0][keterangan]"
                                                                id="tj_keterangan_0" class="form-control"
                                                                placeholder="Keterangan" required>
                                                            <label for="tj_keterangan_0">
                                                                <i class="bi bi-chat-dots me-1"></i>Keterangan *
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-row"
                                                            title="Hapus data ini">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-start mb-4">
                                        <button type="button" class="btn btn-outline-primary" id="add-tanggungjawab">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Tambah Anggota Keluarga
                                        </button>
                                    </div>
                                </div>

                                <!-- Hidden Fields -->
                                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">

                                <!-- Submit Section -->
                                <div class="d-grid gap-3">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-3 py-3" id="submitBtn">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-send me-2"></i>
                                            <span>Kirim Pengajuan</span>
                                            <div class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                                id="loadingSpinner">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </button>
                                    <p class="text-center text-muted mb-0">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Data Anda aman dan terlindungi
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Custom Styles -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-floating>label {
            color: #6c757d;
            font-weight: 500;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label,
        .form-floating>.form-select~label {
            color: #0d6efd;
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .section-header h5 {
            position: relative;
            padding-bottom: 10px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }

        .btn-outline-primary:hover {
            background-color: #667eea;
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .alert-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .text-primary {
            color: #667eea !important;
        }

        .border-primary {
            border-color: #667eea !important;
        }

        .bg-light {
            background-color: #f8f9fc !important;
        }

        #tanggungjawab-wrapper .card {
            transition: all 0.3s ease;
            border: 2px dashed #667eea;
        }

        #tanggungjawab-wrapper .card:hover {
            border-style: solid;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .remove-row:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .progress-indicator {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-lg {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }

            #tanggungjawab-wrapper .row>div {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tjIndex = 1;
            const form = document.getElementById('sktmForm');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Enhanced form validation
            const requiredFields = form.querySelectorAll('[required]');

            // Real-time validation
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });

                field.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            // NIK validation (16 digits)
            const nikFields = form.querySelectorAll('input[name*="nik"]');
            nikFields.forEach(nikField => {
                nikField.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 16) {
                        this.value = this.value.slice(0, 16);
                    }

                    if (this.value.length === 16) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            });

            // Add family member
            document.getElementById('add-tanggungjawab').addEventListener('click', function() {
                const html = `
                <div class="card border-primary bg-light mb-3">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="tanggung_jawab[${tjIndex}][nama]" id="tj_nama_${tjIndex}" class="form-control" 
                                           placeholder="Nama anggota keluarga" required>
                                    <label for="tj_nama_${tjIndex}">
                                        <i class="bi bi-person me-1"></i>Nama *
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <input type="number" name="tanggung_jawab[${tjIndex}][umur]" id="tj_umur_${tjIndex}" class="form-control" 
                                           placeholder="Umur" min="1" max="100" required>
                                    <label for="tj_umur_${tjIndex}">
                                        <i class="bi bi-calendar-date me-1"></i>Umur *
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="tanggung_jawab[${tjIndex}][pekerjaan]" id="tj_pekerjaan_${tjIndex}" class="form-control" 
                                           placeholder="Pekerjaan" required>
                                    <label for="tj_pekerjaan_${tjIndex}">
                                        <i class="bi bi-briefcase me-1"></i>Pekerjaan *
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="tanggung_jawab[${tjIndex}][keterangan]" id="tj_keterangan_${tjIndex}" class="form-control" 
                                           placeholder="Keterangan" required>
                                    <label for="tj_keterangan_${tjIndex}">
                                        <i class="bi bi-chat-dots me-1"></i>Keterangan *
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-row" 
                                        title="Hapus data ini">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;

                document.getElementById('tanggungjawab-wrapper').insertAdjacentHTML('beforeend', html);
                tjIndex++;

                // Add event listeners to new fields
                const newCard = document.getElementById('tanggungjawab-wrapper').lastElementChild;
                const newRequiredFields = newCard.querySelectorAll('[required]');
                newRequiredFields.forEach(field => {
                    field.addEventListener('blur', function() {
                        validateField(this);
                    });

                    field.addEventListener('input', function() {
                        if (this.classList.contains('is-invalid')) {
                            validateField(this);
                        }
                    });
                });

                // Animate the new card
                newCard.style.opacity = '0';
                newCard.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    newCard.style.transition = 'all 0.3s ease';
                    newCard.style.opacity = '1';
                    newCard.style.transform = 'translateY(0)';
                }, 10);
            });

            // Remove family member
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    const card = e.target.closest('.card');

                    // Check if it's the last remaining card
                    const remainingCards = document.querySelectorAll('#tanggungjawab-wrapper .card');
                    if (remainingCards.length <= 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: 'Minimal harus ada 1 anggota keluarga yang menjadi tanggung jawab.',
                            confirmButtonColor: '#667eea'
                        });
                        return;
                    }

                    // Animate removal
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    // Show loading state
                    submitBtn.disabled = true;
                    loadingSpinner.classList.remove('d-none');

                    // Simulate form submission delay
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });

            function validateField(field) {
                const value = field.value.trim();

                if (field.hasAttribute('required') && !value) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                    return false;
                }

                // Special validation for NIK
                if (field.name.includes('nik') && value.length !== 16) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                    return false;
                }

                // Special validation for age
                if (field.type === 'number' && field.name.includes('umur')) {
                    const age = parseInt(value);
                    if (age < 1 || age > 100) {
                        field.classList.add('is-invalid');
                        field.classList.remove('is-valid');
                        return false;
                    }
                }

                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
                return true;
            }

            function validateForm() {
                let isValid = true;

                // Validate all required fields
                const allRequiredFields = form.querySelectorAll('[required]');
                allRequiredFields.forEach(field => {
                    if (!validateField(field)) {
                        isValid = false;
                    }
                });

                // Check if at least one family member exists
                const familyCards = document.querySelectorAll('#tanggungjawab-wrapper .card');
                if (familyCards.length === 0) {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Minimal harus ada 1 anggota keluarga yang menjadi tanggung jawab.',
                        confirmButtonColor: '#667eea'
                    });
                }

                if (!isValid) {
                    // Scroll to first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstInvalid.focus();
                    }

                    // Show error message if no specific error was shown
                    if (familyCards.length > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Mohon lengkapi semua field yang wajib diisi!',
                            confirmButtonColor: '#667eea'
                        });
                    }
                }

                return isValid;
            }

            // Success message on successful submission
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#667eea'
                });
            @endif

            // Error message on failed submission
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#667eea'
                });
            @endif
        });
    </script>
@endpush
