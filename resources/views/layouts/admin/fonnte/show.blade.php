@extends('layouts.dashboard-layouts', ['title' => 'Detail Device WhatsApp'])

@push('styles')
    <style>
        .detail-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .info-item {
            padding: 1rem;
            border-radius: 10px;
            background: #f8f9fa;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .status-active {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
        }

        .status-pending {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: white;
        }

        .btn-action {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea15, #764ba215);
            border: 1px solid #667eea30;
            border-radius: 10px;
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .qr-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content-dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- Header --}}
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary me-3">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <div>
                            <h3 class="mb-0 fw-bold">Detail Device WhatsApp</h3>
                            <p class="text-muted mb-0">Informasi lengkap perangkat WhatsApp Gateway</p>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary btn-action me-2" onclick="refreshDeviceInfo()">
                            <i class="ri-refresh-line me-2"></i>Refresh
                        </button>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-primary btn-action dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="ri-more-line me-2"></i>Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="connectDevice()">
                                        <i class="ri-qr-code-line me-2"></i>Hubungkan Ulang
                                    </a></li>
                                <li><a class="dropdown-item" href="#" onclick="sendTestMessage()">
                                        <i class="ri-message-2-line me-2"></i>Test Pesan
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="disconnectDevice()">
                                        <i class="ri-logout-circle-r-line me-2"></i>Putus Koneksi
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Main Device Info --}}
            <div class="col-lg-8">
                <div class="card detail-card mb-4">
                    <div class="card-header card-header-gradient">
                        <h5 class="mb-0 fw-bold">
                            <i class="ri-smartphone-line me-2"></i>Informasi Device
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div id="device-info-content">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Memuat informasi device...</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Message Test Card --}}
                <div class="card detail-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="ri-message-2-line me-2"></i>Test Pengiriman Pesan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="testMessageForm">
                            <div class="mb-3">
                                <label for="testNumber" class="form-label fw-bold">Nomor Tujuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" class="form-control" id="testNumber" placeholder="81234567890"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="testMessage" class="form-label fw-bold">Pesan</label>
                                <textarea class="form-control" id="testMessage" rows="3" placeholder="Ketik pesan test di sini..." required>Halo! Ini adalah pesan test dari WhatsApp Gateway.</textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-action">
                                <i class="ri-send-plane-2-line me-2"></i>Kirim Test Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Status Card --}}
                <div class="card detail-card mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="ri-smartphone-line text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Status Koneksi</h6>
                        <span class="status-badge" id="status-indicator">
                            <i class="ri-loader-line me-1"></i>Checking...
                        </span>
                        <div class="mt-3">
                            <small class="text-muted">Terakhir dicek: <span id="last-check">-</span></small>
                        </div>
                    </div>
                </div>

                {{-- Statistics --}}
                <div class="card detail-card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="ri-bar-chart-line me-2"></i>Statistik Hari Ini
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="stat-number" id="messages-sent">0</div>
                                    <div class="small text-muted">Pesan Terkirim</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="stat-number" id="messages-failed">0</div>
                                    <div class="small text-muted">Pesan Gagal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- QR Code Card --}}
                <div class="card detail-card">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0 fw-bold">
                            <i class="ri-qr-code-line me-2"></i>QR Code Koneksi
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="qr-container" id="qr-code-container">
                            <i class="ri-qr-code-line text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 mb-3">Klik tombol di bawah untuk generate QR Code</p>
                            <button class="btn btn-warning btn-action" onclick="generateQRCode()">
                                <i class="ri-qr-code-line me-2"></i>Generate QR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QR Code Modal --}}
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="qrModalLabel">
                        <i class="ri-qr-code-line me-2"></i>Scan QR Code untuk Koneksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-modal-content">
                        <div class="p-4">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Meminta QR Code...</p>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <i class="ri-information-line me-2"></i>
                        Buka WhatsApp → Pengaturan → Perangkat Tertaut → Scan QR Code ini
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="refreshQRCode()">
                        <i class="ri-refresh-line me-2"></i>QR Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let deviceId = {{ $device->id ?? 'null' }};
        let deviceData = null;
        let statusCheckInterval = null;

        // Document ready
        $(document).ready(function() {
            if (deviceId) {
                loadDeviceInfo();
                startStatusMonitoring();
            }

            // Test message form
            $('#testMessageForm').on('submit', function(e) {
                e.preventDefault();
                sendTestMessage();
            });
        });

        // Load device information
        function loadDeviceInfo() {
            $.ajax({
                url: `/devices/${deviceId}`,
                method: 'GET',
                success: function(response) {
                    deviceData = response;
                    displayDeviceInfo(response);
                    updateStatusIndicator(response.status);
                },
                error: function() {
                    $('#device-info-content').html(`
                    <div class="alert alert-danger">
                        <i class="ri-error-warning-line me-2"></i>
                        Gagal memuat informasi device
                    </div>
                `);
                }
            });
        }

        // Display device information
        function displayDeviceInfo(data) {
            let html = `
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="ri-device-line text-primary me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Nama Device</h6>
                                <p class="mb-0 text-muted">${data.name || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="ri-phone-line text-success me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Nomor WhatsApp</h6>
                                <p class="mb-0 text-muted">+62${data.device || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="ri-calendar-line text-info me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Tanggal Dibuat</h6>
                                <p class="mb-0 text-muted">${formatDate(data.created_at) || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="ri-key-2-line text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Device Token</h6>
                                <p class="mb-0 text-muted font-monospace">${data.token ? data.token.substring(0, 20) + '...' : 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            ${data.device_info ? `
                                    <hr class="my-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="ri-whatsapp-line text-success me-2"></i>Detail WhatsApp
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-user-line text-primary me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Push Name</h6>
                                                        <p class="mb-0 text-muted">${data.device_info.pushname || 'N/A'}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-smartphone-line text-info me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Platform</h6>
                                                        <p class="mb-0 text-muted">${data.device_info.platform || 'N/A'}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-battery-line text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Battery</h6>
                                                        <p class="mb-0 text-muted">${data.device_info.battery || 'N/A'}%</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-at-line text-warning me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">JID</h6>
                                                        <p class="mb-0 text-muted small">${data.device_info.jid || 'N/A'}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}
        `;

            $('#device-info-content').html(html);
        }

        // Update status indicator
        function updateStatusIndicator(status) {
            let statusBadge = $('#status-indicator');
            let icon = 'ri-circle-fill';
            let text = 'Unknown';
            let className = 'status-inactive';

            switch (status) {
                case 'authenticated':
                    icon = 'ri-check-line';
                    text = 'Terhubung';
                    className = 'status-active';
                    break;
                case 'authenticating':
                    icon = 'ri-loader-line';
                    text = 'Menghubungkan';
                    className = 'status-pending';
                    break;
                default:
                    icon = 'ri-close-line';
                    text = 'Terputus';
                    className = 'status-inactive';
            }

            statusBadge.removeClass('status-active status-inactive status-pending')
                .addClass(className)
                .html(`<i class="${icon} me-1"></i>${text}`);

            $('#last-check').text(new Date().toLocaleTimeString());
        }

        // Start status monitoring
        function startStatusMonitoring() {
            statusCheckInterval = setInterval(function() {
                checkDeviceStatus();
            }, 30000); // Check every 30 seconds
        }

        // Check device status
        function checkDeviceStatus() {
            $.ajax({
                url: `/devices/${deviceId}/status`,
                method: 'GET',
                success: function(response) {
                    updateStatusIndicator(response.status);
                },
                error: function() {
                    updateStatusIndicator('error');
                }
            });
        }

        // Generate QR Code
        function generateQRCode() {
            $('#qrModal').modal('show');
            requestQRCode();
        }

        // Request QR Code
        function requestQRCode() {
            $('#qr-modal-content').html(`
            <div class="p-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Meminta QR Code...</p>
            </div>
        `);

            $.ajax({
                url: `/devices/${deviceId}/activate`,
                method: 'POST',
                data: {
                    device: deviceData?.device || '',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.qr_code) {
                        $('#qr-modal-content').html(`
                        <div class="p-3">
                            <img src="data:image/png;base64,${response.qr_code}" 
                                 class="img-fluid" 
                                 style="max-width: 250px;" 
                                 alt="QR Code">
                            <p class="text-success mt-3">
                                <i class="ri-check-line me-1"></i>
                                Scan QR Code dengan WhatsApp Anda
                            </p>
                        </div>
                    `);
                    } else {
                        showError('Gagal mendapatkan QR Code');
                    }
                },
                error: function(xhr) {
                    let message = 'Gagal meminta QR Code';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }
                    showError(message);
                }
            });
        }

        // Refresh QR Code
        function refreshQRCode() {
            requestQRCode();
        }

        // Send test message
        function sendTestMessage() {
            let number = $('#testNumber').val();
            let message = $('#testMessage').val();

            if (!number || !message) {
                showError('Nomor dan pesan harus diisi');
                return;
            }

            // Show loading
            $('#testMessageForm button').html('<i class="spinner-border spinner-border-sm me-2"></i>Mengirim...');
            $('#testMessageForm button').prop('disabled', true);

            $.ajax({
                url: '/api/send-message',
                method: 'POST',
                data: {
                    target: '+62' + number,
                    message: message,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                headers: {
                    'Authorization': 'Bearer ' + (deviceData?.token || '')
                },
                success: function(response) {
                    showSuccess('Pesan berhasil dikirim!');
                    // Update statistics
                    updateStatistics();
                },
                error: function(xhr) {
                    let message = 'Gagal mengirim pesan';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }
                    showError(message);
                },
                complete: function() {
                    $('#testMessageForm button').html(
                        '<i class="ri-send-plane-2-line me-2"></i>Kirim Test Pesan');
                    $('#testMessageForm button').prop('disabled', false);
                }
            });
        }

        // Update statistics
        function updateStatistics() {
            // This would normally fetch from backend
            let currentSent = parseInt($('#messages-sent').text()) || 0;
            $('#messages-sent').text(currentSent + 1);
        }

        // Connect device
        function connectDevice() {
            generateQRCode();
        }

        // Disconnect device
        function disconnectDevice() {
            if (confirm('Yakin ingin memutus koneksi device ini?')) {
                $.ajax({
                    url: `/devices/${deviceId}/disconnect`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        showSuccess('Device berhasil diputus!');
                        updateStatusIndicator('disconnected');
                    },
                    error: function(xhr) {
                        let message = 'Gagal memutus device';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            message = xhr.responseJSON.error;
                        }
                        showError(message);
                    }
                });
            }
        }

        // Refresh device info
        function refreshDeviceInfo() {
            loadDeviceInfo();
            checkDeviceStatus();
        }

        // Format date
        function formatDate(dateString) {
            if (!dateString) return null;
            return new Date(dateString).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Show success message
        function showSuccess(message) {
            toastr.success(message);
        }

        // Show error message
        function showError(message) {
            toastr.error(message);
        }

        // Cleanup intervals on page unload
        $(window).on('beforeunload', function() {
            if (statusCheckInterval) {
                clearInterval(statusCheckInterval);
            }
        });
    </script>
@endpush
