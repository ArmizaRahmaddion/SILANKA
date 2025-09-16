@extends('layouts.landing-page.layout')
@section('content')
    <!-- Modern Header Section -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        <h1 class="text-white mb-3">
                            <i class="bi bi-person-x me-3"></i>
                            Formulir Surat Keterangan Meninggal Dunia
                        </h1>
                        <p class="text-white-50 mb-0 fs-5">
                            Lengkapi data di bawah ini untuk mengajukan surat keterangan Meninggal Dunia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Form Section -->
    <section class="modern-form-section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-modern">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-modern">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('skkm.store') }}" method="POST" class="modern-form" id="skkm-form">
                @csrf

                <!-- Section 1: Informasi Pengajuan -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-info-circle"></i> Informasi Pengajuan</h4>
                        <p>Masukkan informasi dasar pengajuan surat</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="text" name="keperluan" id="keperluan" class="form-control" required
                                    value="{{ old('keperluan') }}" placeholder=" ">
                                <label for="keperluan">
                                    <i class="fas fa-clipboard-list"></i> Keperluan
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                                    value="{{ date('Y-m-d') }}" readonly placeholder=" ">
                                <label for="tanggal_pengajuan">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Pengajuan
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Almarhum -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-user-times"></i> Data Almarhum</h4>
                        <p>Masukkan data lengkap almarhum/almarhumah</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="text" name="nama_almarhum" id="nama_almarhum" class="form-control" required
                                    value="{{ old('nama_almarhum') }}" placeholder=" ">
                                <label for="nama_almarhum">
                                    <i class="fas fa-user"></i> Nama Lengkap Almarhum
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="text" name="nik_almarhum" id="nik_almarhum" maxlength="16"
                                    class="form-control" required value="{{ old('nik_almarhum') }}" placeholder=" ">
                                <label for="nik_almarhum">
                                    <i class="fas fa-id-card"></i> NIK Almarhum
                                </label>
                                <div class="invalid-feedback"></div>
                                <small class="form-text">16 digit Nomor Induk Kependudukan</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="text" name="tempat_lahir_almarhum" id="tempat_lahir_almarhum"
                                    class="form-control" required value="{{ old('tempat_lahir_almarhum') }}"
                                    placeholder=" ">
                                <label for="tempat_lahir_almarhum">
                                    <i class="fas fa-map-marker-alt"></i> Tempat Lahir
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="date" name="tanggal_lahir_almarhum" id="tanggal_lahir_almarhum"
                                    class="form-control" required value="{{ old('tanggal_lahir_almarhum') }}"
                                    placeholder=" ">
                                <label for="tanggal_lahir_almarhum">
                                    <i class="fas fa-birthday-cake"></i> Tanggal Lahir
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <select name="jenis_kelamin_almarhum" id="jenis_kelamin_almarhum" class="form-control"
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin_almarhum') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin_almarhum') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <label for="jenis_kelamin_almarhum">
                                    <i class="fas fa-venus-mars"></i> Jenis Kelamin
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <select name="agama_almarhum" id="agama_almarhum" class="form-control" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama_almarhum') == 'Islam' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="Kristen" {{ old('agama_almarhum') == 'Kristen' ? 'selected' : '' }}>
                                        Kristen</option>
                                    <option value="Hindu" {{ old('agama_almarhum') == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Budha" {{ old('agama_almarhum') == 'Budha' ? 'selected' : '' }}>Budha
                                    </option>
                                </select>
                                <label for="agama_almarhum">
                                    <i class="fas fa-pray"></i> Agama
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <select name="alamat_almarhum" id="alamat_almarhum" class="form-control" required>
                                    <option value="">Pilih Alamat</option>
                                    <option value="Simpang tiga"
                                        {{ old('alamat_almarhum') == 'Simpang tiga' ? 'selected' : '' }}>
                                        Simpang Tiga</option>
                                    <option value="Koto Ronah"
                                        {{ old('alamat_almarhum') == 'Koto Ronah' ? 'selected' : '' }}>Koto
                                        Ronah</option>
                                    <option value="Koto Tangah"
                                        {{ old('alamat_almarhum') == 'Koto Tangah' ? 'selected' : '' }}>
                                        Koto Tangah</option>
                                    <option value="Polong Duo"
                                        {{ old('alamat_almarhum') == 'Polong Duo' ? 'selected' : '' }}>
                                        Polong Duo</option>
                                </select>
                                <label for="alamat_almarhum">
                                    <i class="fas fa-home"></i> Alamat
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="floating-label">
                                <input type="date" name="tanggal_meninggal" id="tanggal_meninggal"
                                    class="form-control" required value="{{ old('tanggal_meninggal') }}"
                                    placeholder=" ">
                                <label for="tanggal_meninggal">
                                    <i class="fas fa-calendar-times"></i> Tanggal Meninggal
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">

                <!-- Submit Section -->
                <div class="submit-section">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-modern" id="submit-btn">
                            <span class="btn-text">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Pengajuan
                            </span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                    <p class="text-muted text-center mt-3">
                        <i class="fas fa-info-circle"></i>
                        Pastikan semua data yang diisi sudah benar sebelum mengirim
                    </p>
                </div>
            </form>
        </div>
    </section>

    <style>
        /* Modern Header Styling */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .header-icon i {
            font-size: 2rem;
            color: white;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-top: 30px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 100%;
            width: 30px;
            height: 2px;
            background: rgba(255, 255, 255, 0.3);
        }

        .step.active:not(:last-child)::after {
            background: rgba(255, 255, 255, 0.6);
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: white;
            color: #667eea;
            border-color: white;
            transform: scale(1.1);
        }

        .step-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .step.active .step-label {
            opacity: 1;
            font-weight: 600;
        }

        /* Modern Form Section */
        .modern-form-section {
            padding: 60px 0;
            background: #f8fafc;
            min-height: 100vh;
        }

        .modern-form {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-section {
            padding: 40px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .section-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .section-header h4 {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .section-header h4 i {
            color: #667eea;
            margin-right: 10px;
        }

        .section-header p {
            color: #6b7280;
            margin: 0;
        }

        /* Floating Labels */
        .floating-label {
            position: relative;
            margin-bottom: 25px;
        }

        .floating-label input,
        .floating-label select {
            width: 100%;
            padding: 15px 20px 15px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background: white;
            transition: all 0.3s ease;
            color: #1f2937;
        }

        .floating-label input:focus,
        .floating-label select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .floating-label input:not(:placeholder-shown),
        .floating-label input:focus,
        .floating-label select:not([value=""]),
        .floating-label select:focus {
            padding-top: 22px;
            padding-bottom: 8px;
        }

        .floating-label label {
            position: absolute;
            left: 45px;
            top: 15px;
            color: #6b7280;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
            background: white;
            padding: 0 5px;
        }

        .floating-label input:not(:placeholder-shown)+label,
        .floating-label input:focus+label,
        .floating-label select:not([value=""])+label,
        .floating-label select:focus+label {
            top: -8px;
            left: 35px;
            font-size: 12px;
            color: #667eea;
            font-weight: 600;
        }

        .floating-label label i {
            position: absolute;
            left: -25px;
            top: 2px;
            color: #667eea;
            width: 20px;
            text-align: center;
        }

        .floating-label input:focus+label i,
        .floating-label select:focus+label i {
            color: #667eea;
            transform: scale(1.1);
        }

        .floating-label .form-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 5px;
            margin-left: 45px;
        }

        .floating-label .invalid-feedback {
            display: none;
            font-size: 0.875rem;
            color: #ef4444;
            margin-top: 5px;
            margin-left: 45px;
        }

        .floating-label input.is-invalid,
        .floating-label select.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .floating-label input.is-invalid+label,
        .floating-label select.is-invalid+label {
            color: #ef4444;
        }

        .floating-label input.is-invalid~.invalid-feedback,
        .floating-label select.is-invalid~.invalid-feedback {
            display: block;
        }

        /* Submit Section */
        .submit-section {
            padding: 40px;
            background: #f9fafb;
            text-align: center;
        }

        .btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 200px;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-modern:active {
            transform: translateY(0);
        }

        .btn-modern:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Styling */
        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-title {
                font-size: 2rem;
            }

            .progress-indicator {
                gap: 20px;
            }

            .step-number {
                width: 35px;
                height: 35px;
            }

            .form-section {
                padding: 30px 20px;
            }

            .floating-label input,
            .floating-label select {
                padding: 12px 15px 12px 40px;
            }

            .floating-label label {
                left: 40px;
                top: 12px;
            }

            .floating-label input:not(:placeholder-shown)+label,
            .floating-label input:focus+label,
            .floating-label select:not([value=""])+label,
            .floating-label select:focus+label {
                left: 30px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section {
            animation: fadeInUp 0.6s ease forwards;
        }

        .form-section:nth-child(2) {
            animation-delay: 0.1s;
        }

        .form-section:nth-child(3) {
            animation-delay: 0.2s;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('skkm-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');

            // NIK Validation
            const nikInput = document.getElementById('nik_almarhum');
            if (nikInput) {
                nikInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                    validateNIK(this);
                });
            }

            function validateNIK(input) {
                const value = input.value;
                const feedback = input.parentElement.querySelector('.invalid-feedback');

                if (value.length < 16) {
                    input.classList.add('is-invalid');
                    feedback.textContent = 'NIK harus 16 digit';
                } else if (value.length > 16) {
                    input.classList.add('is-invalid');
                    feedback.textContent = 'NIK tidak boleh lebih dari 16 digit';
                } else {
                    input.classList.remove('is-invalid');
                    feedback.textContent = '';
                }
            }

            // Real-time validation for all required fields
            const requiredFields = form.querySelectorAll('[required]');
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

            function validateField(field) {
                const feedback = field.parentElement.querySelector('.invalid-feedback');

                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    feedback.textContent = 'Field ini wajib diisi';
                } else {
                    field.classList.remove('is-invalid');
                    feedback.textContent = '';
                }
            }

            // Date validation - tanggal meninggal tidak boleh lebih dari hari ini
            const tanggalMeninggal = document.getElementById('tanggal_meninggal');
            if (tanggalMeninggal) {
                tanggalMeninggal.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    const feedback = this.parentElement.querySelector('.invalid-feedback');

                    if (selectedDate > today) {
                        this.classList.add('is-invalid');
                        feedback.textContent = 'Tanggal meninggal tidak boleh lebih dari hari ini';
                    } else {
                        this.classList.remove('is-invalid');
                        feedback.textContent = '';
                    }
                });
            }

            // Date validation - tanggal lahir harus sebelum tanggal meninggal
            const tanggalLahir = document.getElementById('tanggal_lahir_almarhum');
            if (tanggalLahir && tanggalMeninggal) {
                function validateDates() {
                    if (tanggalLahir.value && tanggalMeninggal.value) {
                        const lahir = new Date(tanggalLahir.value);
                        const meninggal = new Date(tanggalMeninggal.value);
                        const feedback = tanggalLahir.parentElement.querySelector('.invalid-feedback');

                        if (lahir >= meninggal) {
                            tanggalLahir.classList.add('is-invalid');
                            feedback.textContent = 'Tanggal lahir harus sebelum tanggal meninggal';
                        } else {
                            tanggalLahir.classList.remove('is-invalid');
                            feedback.textContent = '';
                        }
                    }
                }

                tanggalLahir.addEventListener('change', validateDates);
                tanggalMeninggal.addEventListener('change', validateDates);
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate all fields
                let isValid = true;
                requiredFields.forEach(field => {
                    validateField(field);
                    if (field.classList.contains('is-invalid')) {
                        isValid = false;
                    }
                });

                // Special validation for NIK
                if (nikInput) {
                    validateNIK(nikInput);
                    if (nikInput.classList.contains('is-invalid')) {
                        isValid = false;
                    }
                }

                if (!isValid) {
                    // Scroll to first error
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Mohon periksa kembali data yang Anda masukkan',
                        confirmButtonColor: '#667eea'
                    });
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                btnText.style.display = 'none';
                btnLoading.style.display = 'inline-flex';

                // Submit form
                setTimeout(() => {
                    this.submit();
                }, 1000);
            });

            // Auto-uppercase for nama
            const namaInput = document.getElementById('nama_almarhum');
            if (namaInput) {
                namaInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
                });
            }
        });
    </script>
@endsection
