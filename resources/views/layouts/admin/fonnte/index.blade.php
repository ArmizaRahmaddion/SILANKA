@extends('layouts.dashboard-layouts', ['title' => 'Manajemen WhatsApp Gateway'])

@push('styles')
    <style>
        /* Layout */
        .gateway-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        .card-header-gradient {
            background: linear-gradient(#5066e7 0%, #764ba2 100%);
            color: #fff;
            border-radius: 16px;
            padding: 1.4rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-header-gradient:before,
        .card-header-gradient:after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            mix-blend-mode: overlay;
        }

        .card-header-gradient:before {
            width: 160px;
            height: 160px;
            top: -50px;
            right: -40px;
        }

        .card-header-gradient:after {
            width: 100px;
            height: 100px;
            bottom: -35px;
            left: -25px;
        }

        /* Device Cards */
        .device-card {
            transition: all .25s ease;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .device-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px -6px rgba(31, 41, 55, .15);
        }

        .device-card .card-body {
            display: flex;
            flex-direction: column;
            padding: 1.1rem 1.15rem 1.15rem;
        }

        .device-info-block {
            display: grid;
            grid-template-columns: 1fr;
            gap: .35rem;
            margin-bottom: .6rem;
        }

        .device-line {
            display: flex;
            align-items: center;
            font-size: .72rem;
            letter-spacing: .2px;
            color: #374151;
            gap: .45rem;
        }

        .device-line i {
            font-size: .95rem;
            color: #4f46e5;
        }

        .status-badge {
            font-size: .63rem;
            font-weight: 600;
            padding: .40rem .85rem;
            border-radius: 999px;
            letter-spacing: .5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        .status-active {
            background: linear-gradient(45deg, #06c755, #16a34a);
            color: #fff;
        }

        .status-inactive {
            background: linear-gradient(45deg, #dc2626, #ef4444);
            color: #fff;
        }

        .status-pending {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            color: #fff;
        }

        .btn-action {
            border-radius: 8px;
            padding: .55rem .9rem;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .actions {
            margin-top: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .45rem;
        }

        .actions .btn {
            width: 100%;
        }

        /* Make connect button span all columns when shown alone */
        .actions.connecting .btn-connect {
            grid-column: span 3;
        }

        /* Empty State */
        .empty-state-card {
            border: 1px dashed #cbd5e1;
            background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            padding: 3.2rem 2rem;
            text-align: center;
        }

        .empty-state-card i {
            font-size: 3.6rem;
            color: #6366f1;
            opacity: .25;
            margin-bottom: .9rem;
        }

        .empty-state-card h5 {
            font-weight: 700;
            margin-bottom: .4rem;
            letter-spacing: .5px;
        }

        .empty-state-card p {
            max-width: 460px;
            margin: 0 auto 1.4rem;
            font-size: .9rem;
            color: #64748b;
        }

        /* QR Modal */
        #qr-container img {
            border-radius: 12px;
            box-shadow: 0 8px 24px -6px rgba(0, 0, 0, .25);
        }

        /* Utilities */
        .fw-medium {
            font-weight: 600;
        }

        .device-title {
            font-size: 1.02rem;
            font-weight: 700;
            letter-spacing: .4px;
            margin-bottom: .15rem;
            line-height: 1.25;
        }

        .device-sub {
            color: #6b7280;
            font-size: .72rem;
            letter-spacing: .4px;
            font-weight: 500;
            margin: 0;
        }

        /* Responsive tweaks */
        @media (min-width: 1400px) {
            .col-xxl-3 {
                flex: 0 0 auto;
                width: 25%;
            }
        }
    </style>
@endpush

@section('content-dashboard')
    <div class="container-fluid gateway-wrapper">
        <div class="row g-4">
            <div class="col-12">
                <div class="card-header-gradient mb-3 d-flex flex-wrap justify-content-between align-items-center">
                    <div class="pe-3">
                        <h4 class="fw-bold text-white mb-1 d-flex align-items-center" style="letter-spacing:.5px">
                            <i class="ri-smartphone-line me-2"></i>
                            Manajemen WhatsApp Gateway
                        </h4>
                        <p class="mb-0 small text-white opacity-50" style="letter-spacing:.3px">
                            Kelola perangkat WhatsApp untuk notifikasi sistem
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('devices.create') }}"
                            class="btn btn-light btn-action d-inline-flex align-items-center">
                            <i class="ri-add-line me-1"></i> Tambah Device
                        </a>
                        <button class="btn btn-outline-light btn-action d-inline-flex align-items-center"
                            onclick="refreshDevices()">
                            <i class="ri-refresh-line me-1"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12" id="devices-container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-check-line me-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold">#</th>
                                        <th class="px-4 py-3 fw-semibold">Nama</th>
                                        <th class="px-4 py-3 fw-semibold">Phone</th>
                                        <th class="px-4 py-3 fw-semibold">Quota</th>
                                        <th class="px-4 py-3 fw-semibold">Status</th>
                                        <th class="px-4 py-3 fw-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($devices) && count($devices) > 0)
                                        @foreach ($devices as $index => $device)
                                            <tr class="border-bottom" id="device-row-{{ $device->token }}">
                                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-smartphone-line text-primary me-2"></i>
                                                        <div>
                                                            <strong>{{ $device->name }}</strong>
                                                            <br>
                                                            <small
                                                                class="text-muted">{{ substr($device->token, 0, 8) }}...</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="font-monospace text-muted">+{{ $device->device }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <small
                                                        class="text-muted">{{ $device->created_at->format('d M Y') }}</small>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $rawStatus = $device->status ?? $device->is_active;

                                                        if (
                                                            is_bool($rawStatus) ||
                                                            $rawStatus === 1 ||
                                                            $rawStatus === 0 ||
                                                            $rawStatus === '1' ||
                                                            $rawStatus === '0'
                                                        ) {
                                                            $status = filter_var($rawStatus, FILTER_VALIDATE_BOOLEAN)
                                                                ? 'connect'
                                                                : 'disconnect';
                                                        } else {
                                                            $status = strtolower((string) $rawStatus);
                                                        }

                                                        $allowedStatuses = [
                                                            'connect',
                                                            'disconnect',
                                                            'pending',
                                                            'authenticated',
                                                            'active',
                                                            'inactive',
                                                            'error',
                                                        ];
                                                        if (!in_array($status, $allowedStatuses, true)) {
                                                            $status = 'disconnect';
                                                        }

                                                        $statusMeta = [
                                                            'connect' => [
                                                                'label' => 'Connected',
                                                                'icon' => 'ri-wifi-line',
                                                                'class' => 'status-active',
                                                            ],
                                                            'authenticated' => [
                                                                'label' => 'Connected',
                                                                'icon' => 'ri-wifi-line',
                                                                'class' => 'status-active',
                                                            ],
                                                            'active' => [
                                                                'label' => 'Connected',
                                                                'icon' => 'ri-wifi-line',
                                                                'class' => 'status-active',
                                                            ],
                                                            'pending' => [
                                                                'label' => 'Pending',
                                                                'icon' => 'ri-time-line',
                                                                'class' => 'status-pending',
                                                            ],
                                                            'disconnect' => [
                                                                'label' => 'Disconnected',
                                                                'icon' => 'ri-wifi-off-line',
                                                                'class' => 'status-inactive',
                                                            ],
                                                            'inactive' => [
                                                                'label' => 'Disconnected',
                                                                'icon' => 'ri-wifi-off-line',
                                                                'class' => 'status-inactive',
                                                            ],
                                                            'error' => [
                                                                'label' => 'Error',
                                                                'icon' => 'ri-error-warning-line',
                                                                'class' => 'status-inactive',
                                                            ],
                                                        ][$status];
                                                    @endphp
                                                    <span class="status-badge {{ $statusMeta['class'] }}">
                                                        <i
                                                            class="{{ $statusMeta['icon'] }} me-1"></i>{{ $statusMeta['label'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-sm btn-outline-primary" title="View Details"
                                                            onclick="showDeviceDetails('{{ $device->token }}')">
                                                            <i class="ri-eye-line"></i>
                                                        </button>

                                                        @if (in_array($status, ['connect', 'authenticated', 'active']))
                                                            <button class="btn btn-sm btn-outline-success"
                                                                title="Send Test Message"
                                                                onclick="openSendMessageModal('{{ $device->token }}')">
                                                                <i class="ri-message-2-line"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning"
                                                                title="Disconnect Device"
                                                                onclick="disconnectDevice('{{ $device->token }}')">
                                                                <i class="ri-logout-circle-r-line"></i>
                                                            </button>
                                                        @elseif(in_array($status, ['disconnect', 'inactive']))
                                                            <button class="btn btn-sm btn-outline-info"
                                                                title="Generate QR Code"
                                                                onclick="connectDevice('{{ $device->token }}', '{{ $device->device }}')">
                                                                <i class="ri-qr-code-line"></i>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-success" title="Connect Device"
                                                                onclick="connectDevice('{{ $device->token }}', '{{ $device->device }}')">
                                                                <i class="ri-qr-code-line me-1"></i>Connect
                                                            </button>
                                                        @endif

                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete('{{ $device->token }}', '{{ $device->name }}')">
                                                            <i class="ri-delete-bin-line me-1"></i>Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state-content">
                                                    <i class="ri-smartphone-line text-muted" style="font-size: 3rem;"></i>
                                                    <h5 class="mt-3 mb-2">Belum Ada Device</h5>
                                                    <p class="text-muted mb-3">Tambahkan perangkat WhatsApp pertama Anda
                                                        untuk mulai menggunakan gateway notifikasi sistem.</p>
                                                    <a href="{{ route('devices.create') }}" class="btn btn-primary">
                                                        <i class="ri-add-line me-1"></i>Tambah Device Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
                        <i class="ri-qr-code-line me-2"></i>Scan QR Code
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-loading" class="d-none">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0">Meminta QR Code...</p>
                    </div>
                    <div id="qr-container">
                        <div class="p-4">
                            <i class="ri-qr-code-line" style="font-size:3rem;color:#d1d5db;"></i>
                            <p class="text-muted mt-2 mb-0">QR Code akan muncul di sini</p>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3 text-start small mb-0">
                        <i class="ri-information-line me-2"></i>
                        <strong>Cara menggunakan:</strong><br>
                        Buka WhatsApp → Pengaturan → Perangkat Tertaut → Tautkan Perangkat → Scan QR Code
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="requestNewQR()">
                        <i class="ri-refresh-line me-1"></i> QR Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Device Details Modal --}}
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detailsModalLabel">
                        <i class="ri-information-line me-2"></i>Detail Device
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="device-details-content">
                        <div class="text-center py-4">
                            <div class="spinner-border text-info" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 small mb-0">Memuat detail device...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Send Message Modal --}}
    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="sendMessageModalLabel">
                        <i class="ri-message-2-line me-2"></i>Kirim Pesan Test
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="sendMessageForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="send-device-token" value="">
                        <div class="mb-3">
                            <label for="test-phone" class="form-label">Nomor Tujuan</label>
                            <input type="text" class="form-control" id="test-phone" placeholder="628123456789"
                                required>
                            <div class="form-text">Format: 628123456789 (tanpa tanda +)</div>
                        </div>
                        <div class="mb-3">
                            <label for="test-message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="test-message" rows="3" placeholder="Masukkan pesan test..." required>Halo, ini adalah pesan test dari sistem E-Surat.</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-send-plane-line me-1"></i>Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentDeviceToken = null;
        let qrInterval = null;

        $(function() {
            setInterval(refreshDevices, 30000);
        });

        function refreshDevices() {
            location.reload();
        }

        function connectDevice(deviceToken, phoneNumber) {
            currentDeviceToken = deviceToken;
            $('#qrModal').modal('show');
            $('#qr-loading').removeClass('d-none');
            $('#qr-container').addClass('d-none');
            requestQRCode(deviceToken, phoneNumber);
        }

        function requestQRCode(deviceToken, phoneNumber) {
            $.ajax({
                url: `/devices/${deviceToken}/activate`,
                method: 'POST',
                data: {
                    device: phoneNumber,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.qr_code) {
                        displayQRCode(response.qr_code);
                        startConnectionCheck(deviceToken);
                    } else {
                        showError('Gagal mendapatkan QR Code');
                    }
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.error || 'Gagal meminta QR Code');
                }
            });
        }

        function displayQRCode(qrCodeData) {
            $('#qr-loading').addClass('d-none');
            $('#qr-container').removeClass('d-none').html(`
                <div class="p-2">
                    <img src="data:image/png;base64,${qrCodeData}" class="img-fluid" style="max-width:260px;" alt="QR Code">
                    <p class="text-success mt-3 mb-0 small fw-medium">
                        <i class="ri-check-line me-1"></i>Scan QR Code dengan WhatsApp Anda
                    </p>
                </div>
            `);
        }

        function openSendMessageModal(deviceToken) {
            $('#send-device-token').val(deviceToken);
            $('#sendMessageModal').modal('show');
        }

        $('#sendMessageForm').on('submit', function(e) {
            e.preventDefault();
            sendTestMessage();
        });

        function sendTestMessage() {
            const token = $('#send-device-token').val();
            const phone = $('#test-phone').val();
            const message = $('#test-message').val();

            if (!phone || !message) {
                showError('Mohon lengkapi semua field');
                return;
            }

            $.ajax({
                url: '/devices/send-message',
                method: 'POST',
                data: {
                    token: token,
                    phone: phone,
                    message: message,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        showSuccess('Pesan berhasil dikirim!');
                        $('#sendMessageModal').modal('hide');
                        $('#sendMessageForm')[0].reset();
                    } else {
                        showError(response.message || 'Gagal mengirim pesan');
                    }
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.message || 'Gagal mengirim pesan');
                }
            });
        }

        function startConnectionCheck(deviceToken) {
            qrInterval = setInterval(function() {
                checkConnectionStatus(deviceToken);
            }, 5000);
        }

        function checkConnectionStatus(deviceToken) {
            $.ajax({
                url: `/devices/${deviceToken}/status`,
                method: 'GET',
                success: function(response) {
                    if (response.status === 'authenticated' || response.status === 'active') {
                        clearInterval(qrInterval);
                        $('#qrModal').modal('hide');
                        showSuccess('Device berhasil terhubung!');
                        refreshDevices();
                    }
                }
            });
        }

        function requestNewQR() {
            if (currentDeviceToken) {
                requestQRCode(currentDeviceToken, '');
            }
        }

        function disconnectDevice(deviceToken) {
            if (!confirm('Yakin ingin memutus koneksi device ini?')) {
                return;
            }
            $.ajax({
                url: `/devices/${deviceToken}/disconnect`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    showSuccess('Device berhasil diputus!');
                    refreshDevices();
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.error || 'Gagal memutus device');
                }
            });
        }

        function showDeviceDetails(deviceToken) {
            $('#detailsModal').modal('show');
            $.ajax({
                url: `/devices/${deviceToken}`,
                method: 'GET',
                success: function(response) {
                    displayDeviceDetails(response);
                },
                error: function() {
                    $('#device-details-content').html(`
                        <div class="alert alert-danger mb-0 small">
                            <i class="ri-error-warning-line me-1"></i> Gagal memuat detail device
                        </div>
                    `);
                }
            });
        }

        function displayDeviceDetails(data) {
            $('#device-details-content').html(`
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2 text-uppercase small text-muted">Informasi Umum</h6>
                        <table class="table table-sm mb-0">
                            <tr><td class="fw-medium small">Nama</td><td class="small">${data.name || 'N/A'}</td></tr>
                            <tr><td class="fw-medium small">Nomor</td><td class="small">${data.device || 'N/A'}</td></tr>
                            <tr><td class="fw-medium small">Status</td>
                                <td class="small">
                                    <span class="badge bg-${data.status === 'authenticated' ? 'success' : data.status === 'pending' ? 'warning' : 'secondary'}">
                                        ${data.status || 'N/A'}
                                    </span>
                                </td>
                            </tr>
                            <tr><td class="fw-medium small">Token</td>
                                <td class="small"><code>${data.token ? data.token.substring(0,20)+'...' : 'N/A'}</code></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2 text-uppercase small text-muted">Detail WhatsApp</h6>
                        <table class="table table-sm mb-0">
                            <tr><td class="fw-medium small">Push Name</td><td class="small">${data.device_info?.pushname || 'N/A'}</td></tr>
                            <tr><td class="fw-medium small">JID</td><td class="small">${data.device_info?.jid || 'N/A'}</td></tr>
                            <tr><td class="fw-medium small">Platform</td><td class="small">${data.device_info?.platform || 'N/A'}</td></tr>
                            <tr><td class="fw-medium small">Battery</td><td class="small">${data.device_info?.battery || 'N/A'}%</td></tr>
                        </table>
                    </div>
                </div>
            `);
        }

        function confirmDelete(deviceToken, deviceName = '') {
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Device?',
                html: `<div class="text-start small">
                    <p class="mb-1">Anda akan menghapus perangkat <strong>${deviceName || 'Device'}</strong>.</p>
                    <p class="mb-0">Langkah ini membutuhkan OTP yang dikirim ke WhatsApp perangkat terkait.</p>
                   </div>`,
                showCancelButton: true,
                confirmButtonText: 'Kirim OTP',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }
                requestDeleteOTP(deviceToken);
            });
        }

        function requestDeleteOTP(deviceToken) {
            $.ajax({
                url: `/devices/${deviceToken}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (!response.status) {
                        showError(response.message || 'Gagal mengirim OTP.');
                        return;
                    }
                    showSuccess(response.message || 'OTP terkirim.');
                    promptOTPAndDelete(deviceToken);
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.message || 'Gagal mengirim OTP.');
                }
            });
        }

        function promptOTPAndDelete(deviceToken) {
            Swal.fire({
                title: 'Masukkan OTP',
                input: 'text',
                inputLabel: 'Kode OTP yang dikirim via WhatsApp',
                inputAttributes: {
                    maxlength: 6,
                    autocomplete: 'one-time-code',
                    inputmode: 'numeric'
                },
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                preConfirm: function(otp) {
                    if (!otp) {
                        Swal.showValidationMessage('OTP wajib diisi');
                        return false;
                    }
                    return $.ajax({
                        url: `/devices/${deviceToken}`,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            otp: otp
                        }
                    }).then(function(resp) {
                        if (!resp.status) {
                            throw new Error(resp.message || 'Gagal menghapus perangkat.');
                        }
                        return resp;
                    }).catch(function(err) {
                        Swal.showValidationMessage(err.responseJSON?.message || err.message ||
                            'Gagal menghapus perangkat.');
                    });
                }
            }).then(function(result) {
                if (result.isConfirmed && result.value) {
                    showSuccess(result.value.message || 'Perangkat berhasil dihapus.');
                    refreshDevices();
                }
            });
        }

        // Backward compatibility if some part still calls deleteDevice directly with known OTP
        function deleteDevice(deviceToken, otp) {
            if (!otp) {
                confirmDelete(deviceToken);
                return;
            }
            $.ajax({
                url: `/devices/${deviceToken}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    otp: otp
                },
                success: function(response) {
                    if (response.status) {
                        showSuccess(response.message || 'Perangkat berhasil dihapus.');
                        refreshDevices();
                    } else {
                        showError(response.message || 'Gagal menghapus perangkat.');
                    }
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.message || 'Gagal menghapus perangkat.');
                }
            });
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

        $('#qrModal').on('hidden.bs.modal', function() {
            if (qrInterval) {
                clearInterval(qrInterval);
                qrInterval = null;
            }
        });
    </script>
@endpush
