@extends('layouts.landing-page.layout')
@section('content')
    <!-- Modern Page Header -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        <h1 class="text-white mb-3">
                            <i class="bi bi-geo-alt me-3"></i>
                            Formulir Surat Keterangan Domisili
                        </h1>
                        <p class="text-white-50 mb-0 fs-5">
                            Lengkapi data di bawah ini untuk mengajukan surat keterangan domisili
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Form Section -->
    <section id="form-skd" class="py-5 bg-light">
        <div class="container">
            <!-- Main Form Card -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-header bg-white border-0 py-4">
                            <h4 class="card-title text-center mb-0">
                                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                                Form Pengajuan Surat Keterangan Domisili
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('skd.store') }}" method="POST" id="skdForm" autocomplete="off">
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
                                                    placeholder="Contoh: Keperluan administrasi" required
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
                                <!-- Section 2: Data Pribadi -->
                                <div class="form-section mb-5">
                                    <div class="section-header mb-4">
                                        <h5 class="text-primary fw-bold mb-2">
                                            <i class="bi bi-person-circle me-2"></i>
                                            Data Pribadi
                                        </h5>
                                        <hr class="border-primary opacity-25">
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="nama" id="nama" class="form-control"
                                                    placeholder="Nama lengkap sesuai KTP" required
                                                    value="{{ old('nama') }}">
                                                <label for="nama">
                                                    <i class="bi bi-person me-2"></i>Nama Lengkap *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="nik" id="nik" maxlength="16"
                                                    class="form-control" placeholder="Masukkan 16 digit NIK" required
                                                    value="{{ old('nik') }}">
                                                <label for="nik">
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
                                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                                    class="form-control" placeholder="Tempat lahir sesuai KTP" required
                                                    value="{{ old('tempat_lahir') }}">
                                                <label for="tempat_lahir">
                                                    <i class="bi bi-geo-alt me-2"></i>Tempat Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                                    class="form-control" required value="{{ old('tanggal_lahir') }}">
                                                <label for="tanggal_lahir">
                                                    <i class="bi bi-calendar me-2"></i>Tanggal Lahir *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select"
                                                    required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-Laki"
                                                        {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                <label for="jenis_kelamin">
                                                    <i class="bi bi-gender-ambiguous me-2"></i>Jenis Kelamin *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="status_perkawinan" id="status_perkawinan"
                                                    class="form-select" required>
                                                    <option value="">Pilih Status Perkawinan</option>
                                                    <option value="Belum Kawin"
                                                        {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>
                                                        Belum Kawin
                                                    </option>
                                                    <option value="Kawin"
                                                        {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>
                                                        Kawin
                                                    </option>
                                                    <option value="Cerai Hidup"
                                                        {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>
                                                        Cerai Hidup
                                                    </option>
                                                    <option value="Cerai Mati"
                                                        {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>
                                                        Cerai Mati
                                                    </option>
                                                </select>
                                                <label for="status_perkawinan">
                                                    <i class="bi bi-heart me-2"></i>Status Perkawinan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select name="agama" id="agama" class="form-select" required>
                                                    <option value="">Pilih Agama</option>
                                                    <option value="Islam"
                                                        {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                    <option value="Kristen"
                                                        {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                    <option value="Hindu"
                                                        {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                    <option value="Budha"
                                                        {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                                    <option value="Konghucu"
                                                        {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                                    </option>
                                                </select>
                                                <label for="agama">
                                                    <i class="bi bi-peace me-2"></i>Agama *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="pekerjaan" id="pekerjaan"
                                                    class="form-control" placeholder="Contoh: Karyawan Swasta" required
                                                    value="{{ old('pekerjaan') }}">
                                                <label for="pekerjaan">
                                                    <i class="bi bi-briefcase me-2"></i>Pekerjaan *
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <select name="alamat" id="alamat" class="form-select" required>
                                                    <option value="">Pilih Alamat</option>
                                                    <option value="Simpang Tiga"
                                                        {{ old('alamat') == 'Simpang Tiga' ? 'selected' : '' }}>
                                                        Simpang Tiga
                                                    </option>
                                                    <option value="Koto Ronah"
                                                        {{ old('alamat') == 'Koto Ronah' ? 'selected' : '' }}>
                                                        Koto Ronah
                                                    </option>
                                                    <option value="Koto Tangah"
                                                        {{ old('alamat') == 'Koto Tangah' ? 'selected' : '' }}>
                                                        Koto Tangah
                                                    </option>
                                                    <option value="Polong Duo"
                                                        {{ old('alamat') == 'Polong Duo' ? 'selected' : '' }}>
                                                        Polong Duo
                                                    </option>
                                                </select>
                                                <label for="alamat">
                                                    <i class="bi bi-house me-2"></i>Alamat *
                                                </label>
                                            </div>
                                        </div>
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
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('skdForm');
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
            const nikField = document.getElementById('nik');
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
                if (field.id === 'nik' && value.length !== 16) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                    return false;
                }

                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
                return true;
            }

            function validateForm() {
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!validateField(field)) {
                        isValid = false;
                    }
                });

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

                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon lengkapi semua field yang wajib diisi!',
                        confirmButtonColor: '#667eea'
                    });
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
@endsection
