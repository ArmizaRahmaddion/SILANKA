@extends('layouts.dashboard-layouts', ['title' => 'Tambah Device WhatsApp'])

@push('styles')
    <style>
        :root {
            --brand-gradient: linear-gradient(135deg, #6366f1 0%, #764ba2 100%);
            --brand-primary: #6366f1;
            --brand-surface: #f5f7fb;
            --radius-lg: 1.25rem;
            --radius-md: .85rem;
            --transition: .35s cubic-bezier(.4, 0, .2, 1);
        }

        body {
            background: var(--brand-surface);
        }

        .page-wrapper {
            animation: fadeIn .5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modern-card {
            border: 0;
            border-radius: var(--radius-lg);
            background: #fff;
            box-shadow: 0 4px 12px -2px rgba(28, 30, 35, .06), 0 12px 28px -4px rgba(28, 30, 35, .08);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .modern-card:hover {
            box-shadow: 0 6px 18px -2px rgba(28, 30, 35, .08), 0 18px 34px -6px rgba(28, 30, 35, .12);
            transform: translateY(-2px);
        }

        .card-header-gradient {
            background: var(--brand-gradient);
            color: #fff;
            padding: 1rem 1.25rem;
            border: 0;
        }

        .card-header-gradient h5 {
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: .3px;
        }

        .step-indicator {
            position: relative;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-lg);
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .04);
            margin-bottom: 1.75rem;
        }

        .step-indicator:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 2.8rem;
            right: 2.8rem;
            height: 3px;
            background: linear-gradient(90deg, #e5e7ef, #e5e7ef);
            transform: translateY(-50%);
            z-index: 1;
        }

        .step-block {
            position: relative;
            z-index: 2;
            flex: 1;
            text-align: center;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            margin: 0 auto .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            font-size: .95rem;
            color: #55607a;
            background: #eef1f7;
            box-shadow: 0 0 0 4px #fff;
            transition: var(--transition);
        }

        .step-block.active .step-circle {
            background: var(--brand-primary);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
        }

        .step-label {
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .step-block.active .step-label {
            color: #111827;
        }

        .form-control,
        .input-group-text {
            border-radius: var(--radius-md);
            padding: .85rem 1rem;
            border: 2px solid #e5e7ef;
            background: #fff;
            font-size: .95rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .15);
        }

        .input-group-text {
            font-weight: 600;
            background: #f1f4fa;
            color: #374151;
        }

        label.form-label {
            font-weight: 600;
            font-size: .9rem;
            color: #374151;
        }

        .btn-action {
            border-radius: var(--radius-md);
            font-weight: 600;
            letter-spacing: .3px;
            padding: .85rem 1.4rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .btn-primary.btn-action {
            background: var(--brand-primary);
            border: 0;
        }

        .btn-primary.btn-action:hover {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .btn-outline-secondary.btn-action:hover {
            background: #f3f4f6;
        }

        .supporting-badge {
            background: #eef2ff;
            color: var(--brand-primary);
            padding: .35rem .7rem;
            border-radius: 50rem;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        /* Info list */
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            display: flex;
            gap: .65rem;
            font-size: .85rem;
            padding: .55rem 0;
            border-bottom: 1px dashed #eef0f5;
        }

        .info-list li:last-child {
            border-bottom: 0;
        }

        .info-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #ecfdf5;
            color: #059669;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .quick-actions .btn {
            border-radius: .75rem;
            font-weight: 600;
            font-size: .75rem;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: .65rem .9rem;
        }

        .modal-content {
            border: 0;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 28px -4px rgba(0, 0, 0, .25);
        }

        .modal-header.bg-success {
            background: linear-gradient(120deg, #16a34a, #10b981);
        }

        /* Responsive tweaks */
        @media (max-width: 991.98px) {
            .step-indicator {
                flex-wrap: wrap;
                gap: .75rem;
            }

            .step-block {
                flex: 0 0 calc(33.333% - .5rem);
            }
        }
    </style>
@endpush

@section('content-dashboard')
    <div class="container-fluid gateway-wrapper ">
        <div class="row g-4">
            <div class="col-12">
                <div class="card-header-gradient mb-3 d-flex flex-wrap justify-content-between align-items-center rounded-4">
                    <div class="pe-3">
                        <h4 class="fw-bold mb-1 d-flex align-items-center" style="letter-spacing:.5px">
                            <i class="ri-smartphone-line me-2"></i>
                            Manajemen WhatsApp Gateway
                        </h4>
                        <p class="mb-0 small opacity-75" style="letter-spacing:.3px">
                            Tambahkan perangkat WhatsApp baru untuk digunakan sebagai gateway notifikasi
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('devices.index') }}"
                            class="btn btn-light btn-action d-inline-flex align-items-center">
                            <i class="ri-arrow-left-line me-1"></i> Kembali
                        </a>
                        <button class="btn btn-outline-light btn-action d-inline-flex align-items-center"
                            onclick="testConnection()">
                            <i class="ri-wifi-line me-1"></i> Test Koneksi
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="step-indicator">
                    <div class="step-block active">
                        <div class="step-circle">1</div>
                        <div class="step-label">Daftar Device</div>
                    </div>
                    <div class="step-block">
                        <div class="step-circle">2</div>
                        <div class="step-label">Scan QR</div>
                    </div>
                    <div class="step-block">
                        <div class="step-circle">3</div>
                        <div class="step-label">Aktif</div>
                    </div>
                </div>

                <div class="modern-card mb-4">
                    <div class="card-header card-header-gradient d-flex align-items-center">
                        <h5 class="mb-0">
                            <i class="ri-smartphone-line me-2"></i> Informasi Device
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ri-error-warning-line me-2"></i>
                                    <strong>Oops! Terjadi kesalahan:</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('devices.store') }}" method="POST" id="deviceForm" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="ri-device-line text-primary me-1"></i> Nama Device
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: WhatsApp Gateway Utama" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">
                                    <i class="ri-information-line me-1"></i>
                                    Berikan nama yang mudah diingat
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="device" class="form-label">
                                    <i class="ri-phone-line text-primary me-1"></i> Nomor WhatsApp
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">62</span>
                                    <input type="text" class="form-control @error('device') is-invalid @enderror"
                                        id="device" name="device" value="{{ old('device') }}" placeholder="8123456789"
                                        pattern="[0-9]{8,13}" required>
                                    @error('device')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text mt-2">
                                    <i class="ri-information-line me-1"></i>
                                    Masukkan tanpa awalan 0 (contoh: 8123456789)
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-2 justify-content-between pt-2">
                                <a href="{{ route('devices.index') }}"
                                    class="btn btn-outline-secondary btn-action w-100 w-md-auto">
                                    <i class="ri-close-line me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary btn-action w-100 w-md-auto" id="submitBtn">
                                    <i class="ri-add-line me-1"></i> Daftar Device
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="modern-card h-100">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                                    <i class="ri-lightbulb-line me-2"></i> Catatan Penting
                                </h6>
                                <ul class="info-list">
                                    <li><span class="info-icon"><i class="ri-check-line"></i></span> Pastikan nomor aktif &
                                        dapat menerima pesan</li>
                                    <li><span class="info-icon"><i class="ri-qr-code-line"></i></span> Setelah daftar Anda
                                        akan
                                        scan QR Code</li>
                                    <li><span class="info-icon"><i class="ri-device-line"></i></span> Satu nomor hanya untuk
                                        satu device</li>
                                    <li><span class="info-icon"><i class="ri-time-line"></i></span> Device disconnect
                                        otomatis
                                        bila idle 24 jam</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="modern-card h-100 quick-actions">
                            <div class="card-body p-4 d-flex flex-column">
                                <h6 class="fw-bold mb-3 d-flex align-items-center">
                                    <i class="ri-rocket-line text-primary me-2"></i> Aksi Cepat
                                </h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('devices.index') }}" class="btn btn-outline-primary">
                                        <i class="ri-list-check-3 me-1"></i> Lihat Semua Device
                                    </a>
                                    <button class="btn btn-outline-success" type="button" onclick="testConnection()">
                                        <i class="ri-wifi-line me-1"></i> Test Koneksi
                                    </button>
                                </div>
                                <div class="mt-4 small text-muted">
                                    <i class="ri-shield-check-line me-1 text-success"></i>
                                    Koneksi terenkripsi & aman
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Success Modal --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="ri-check-line me-2"></i> Device Berhasil Didaftarkan!
                    </h5>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="ri-smartphone-line text-success" style="font-size:3rem;"></i>
                    </div>
                    <h6 class="fw-semibold mb-2">Langkah Selanjutnya</h6>
                    <p class="text-muted mb-4">Device siap dihubungkan ke WhatsApp. Lanjutkan untuk scan QR Code
                        sekarang.
                    </p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-action" onclick="connectNewDevice()">
                            <i class="ri-qr-code-line me-1"></i> Hubungkan Sekarang
                        </button>
                        <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary btn-action">
                            Hubungkan Nanti
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let newDeviceId = null;

        $(document).ready(function() {
            $('#device').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 13) {
                    value = value.substring(0, 13);
                }
                $(this).val(value);
            });

            $('#deviceForm').on('submit', function(e) {
                let isValid = validateForm();
                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
                $('#submitBtn').html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Mendaftarkan...');
                $('#submitBtn').prop('disabled', true);
            });

            @if (session('success'))
                showSuccess('{{ session('success') }}');
            @endif

            @if (session('device_id'))
                newDeviceId = '{{ session('device_id') }}';
                $('#successModal').modal('show');
            @endif
        });

        function validateForm() {
            let name = $('#name').val().trim();
            if (name.length < 3) {
                showError('Nama device minimal 3 karakter');
                $('#name').focus();
                return false;
            }

            let phone = $('#device').val().trim();
            if (phone.length < 8 || phone.length > 13) {
                showError('Nomor WhatsApp harus 8-13 digit');
                $('#device').focus();
                return false;
            }
            if (phone.startsWith('0')) {
                showError('Nomor WhatsApp tidak perlu diawali 0');
                $('#device').focus();
                return false;
            }
            return true;
        }

        function testConnection() {
            showInfo('Menguji koneksi ke Fonnte API ...');
            $.ajax({
                url: '{{ route('devices.test.connection') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        showSuccess('Koneksi ke Fonnte API berhasil!');
                    } else {
                        showError('Koneksi gagal: ' + (response.error || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    let message = 'Koneksi gagal. Periksa konfigurasi token.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }
                    showError(message);
                }
            });
        }

        function connectNewDevice() {
            if (newDeviceId) {
                $('#successModal').modal('hide');
                window.location.href = '{{ route('devices.index') }}?connect=' + newDeviceId;
            }
        }

        function swalToast(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

        function showSuccess(message) {
            swalToast('success', message);
        }

        function showError(message) {
            swalToast('error', message);
        }

        function showInfo(message) {
            swalToast('info', message);
        }
    </script>
@endsection
