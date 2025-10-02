@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>RIWAYAT PENGAJUAN SURAT</h1>
                        <p class="mb-0">Pantau status dan riwayat pengajuan surat Anda dengan mudah.
                            Lihat detail proses dari setiap tahapan pengajuan surat yang telah Anda ajukan.</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="#">Beranda</a></li>
                    <li class="current">Riwayat Surat</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <section id="riwayat-surat" class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-white d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="bi bi-files me-2 text-primary"></i> Riwayat Pengajuan Surat
                                </h5>
                                <p class="mb-0 text-muted small">
                                    Lacak status, detail, dan progres setiap surat yang Anda ajukan.
                                </p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchRiwayat" class="form-control"
                                        placeholder="Cari nomor / jenis / status...">
                                </div>
                                <div class="d-flex align-items-center gap-2 small flex-wrap">
                                    <span class="badge bg-success">Selesai</span>
                                    <span class="badge bg-info">Diterima</span>
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                    <span class="badge bg-danger">Ditolak</span>
                                    <span class="badge bg-secondary">Batal</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="riwayatSuratTable" class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:60px;">No.</th>
                                            <th style="min-width:160px;">Nomor Surat</th>
                                            <th style="min-width:200px;">Jenis Surat</th>
                                            <th style="min-width:140px;">Tanggal Permintaan</th>
                                            <th style="min-width:120px;">Status</th>
                                            <th style="min-width:140px;">Detail</th>
                                            <th style="min-width:120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @php
                                            $statusBadgeMap = [
                                                'Selesai' => 'success',
                                                'Sedang Diproses' => 'warning',
                                                'Menunggu' => 'secondary',
                                                'Ditolak' => 'danger',
                                                'Dibatalkan' => 'dark',
                                            ];
                                        @endphp
                                        @forelse ($riwayatSurat as $surat)
                                            @php
                                                $status = $surat->status;
                                                $badgeClass = $statusBadgeMap[$status] ?? 'secondary';
                                                $nomorSurat = optional($surat->suratTerbit->first())->nomor_surat;
                                            @endphp
                                            <tr class="data-row">
                                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                                <td class="fw-medium">
                                                    {{ $nomorSurat ?? '—' }}
                                                </td>
                                                <td>{{ $surat->jenisSurat->nama_surat ?? '—' }}</td>
                                                <td>
                                                    <span class="text-nowrap">
                                                        {{ $surat->tanggal_permintaan->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $badgeClass }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-info btn-sm px-3 d-inline-flex align-items-center gap-1"
                                                        data-bs-toggle="modal" data-bs-target="#modalDetail"
                                                        data-jenis="{{ $surat->jenisSurat->nama_surat ?? '-' }}"
                                                        data-tanggal="{{ $surat->tanggal_permintaan->translatedFormat('d F Y') }}"
                                                        data-nomor="{{ $nomorSurat ?? '-' }}"
                                                        data-status="{{ $status }}">
                                                        <i class="bi bi-eye"></i><span>Detail</span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm px-3 d-inline-flex align-items-center gap-1"
                                                        data-bs-toggle="modal" data-bs-target="#modalRiwayat"
                                                        data-bagian="{{ $surat->bagian_saat_ini ?? 'Tata Usaha' }}"
                                                        data-status="{{ $status }}"
                                                        data-tanggal="{{ $surat->tanggal_permintaan->translatedFormat('d F Y') }}">
                                                        <i class="bi bi-clock-history"></i><span>Riwayat</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-info btn-sm px-3 d-inline-flex align-items-center gap-1"
                                                        onclick="window.open('{{ route('surat.check.form') }}', '_blank')"
                                                        {{ $status !== 'Selesai' ? 'disabled' : '' }}>
                                                        <i class="bi bi-download"></i><span>Unduh</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="emptyStateRow">
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                                        Belum ada riwayat pengajuan surat.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody> --}}

                                    <tbody>
                                        @forelse ($riwayatSurat as $surat)
                                            @php
                                                // Tentukan badge class berdasarkan status
                                                $statusBadgeMap = [
                                                    'Selesai' => 'success',
                                                    'Diterima' => 'info',
                                                    'Diproses' => 'warning',
                                                    'Ditolak' => 'danger',
                                                    'Batal' => 'secondary',
                                                ];
                                                $badgeClass = $statusBadgeMap[$surat->status] ?? 'secondary';

                                                // Ambil nomor surat dari relasi suratTerbit
                                                $nomorSurat = optional($surat->suratTerbit->first())->nomor_surat;

                                                // Tentukan bagian saat ini berdasarkan status terakhir
                                                $bagianSaatIni = $surat->bagian_saat_ini;
                                            @endphp
                                            <tr class="data-row">
                                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                                <td class="fw-medium">
                                                    {{ $nomorSurat ?? '—' }}
                                                    @if (!$nomorSurat && $surat->status !== 'Ditolak')
                                                        <br><small class="text-muted">Belum diproses</small>
                                                    @endif
                                                </td>
                                                <td>{{ $surat->jenisSurat->nama_surat ?? '—' }}</td>
                                                <td>
                                                    <span class="text-nowrap">
                                                        {{ $surat->tanggal_permintaan->format('d/m/Y') }}
                                                    </span>
                                                    <br><small
                                                        class="text-muted">{{ $surat->tanggal_permintaan->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $badgeClass }}">
                                                        {{ $surat->status }}
                                                    </span>
                                                    @if ($surat->status === 'Ditolak' && !empty($surat->keterangan))
                                                        <br><small
                                                            class="text-danger">{{ Str::limit($surat->keterangan, 30) }}</small>
                                                    @elseif (in_array($surat->status, ['Diproses', 'Diterima']) && $bagianSaatIni)
                                                        <br><small class="text-info">Di {{ $bagianSaatIni }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-info btn-sm px-3 d-inline-flex align-items-center gap-1"
                                                        data-bs-toggle="modal" data-bs-target="#modalDetail"
                                                        data-jenis="{{ $surat->jenisSurat->nama_surat ?? '-' }}"
                                                        data-tanggal="{{ $surat->tanggal_permintaan->translatedFormat('d F Y') }}"
                                                        data-nomor="{{ $nomorSurat ?? '-' }}"
                                                        data-status="{{ $surat->status }}"
                                                        data-bagian="{{ $bagianSaatIni }}">
                                                        <i class="bi bi-eye"></i><span>Detail</span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 flex-wrap">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm px-3 d-inline-flex align-items-center gap-1"
                                                            onclick="loadRiwayatStatus({{ $surat->id }})"
                                                            data-bs-toggle="modal" data-bs-target="#modalRiwayat">
                                                            <i class="bi bi-clock-history"></i><span>Riwayat</span>
                                                        </button>

                                                        @if ($surat->status === 'Selesai' && $nomorSurat)
                                                            <!-- Print Surat -->
                                                            @php
                                                                $kodeSurat = $surat->jenisSurat->kode_surat;
                                                            @endphp

                                                            @switch($kodeSurat)
                                                                @case('SKKM')
                                                                    @if ($surat->suratKeteranganMeninggalDunia)
                                                                        <a href="{{ route('skkm.print', $surat->suratKeteranganMeninggalDunia->id) }}"
                                                                            class="btn btn-sm btn-success" title="Print Surat"
                                                                            target="_blank">
                                                                            <i class="bi bi-printer"></i>
                                                                        </a>
                                                                    @endif
                                                                @break

                                                                @case('SKD')
                                                                    @if ($surat->suratKeteranganDomisili)
                                                                        <a href="{{ route('skd.print', $surat->suratKeteranganDomisili->id) }}"
                                                                            class="btn btn-sm btn-success" title="Print Surat"
                                                                            target="_blank">
                                                                            <i class="bi bi-printer"></i>
                                                                        </a>
                                                                    @endif
                                                                @break

                                                                @case('SKU')
                                                                    @if ($surat->suratKeteranganUsaha)
                                                                        <a href="{{ route('sku.print', $surat->suratKeteranganUsaha->id) }}"
                                                                            class="btn btn-sm btn-success" title="Print Surat"
                                                                            target="_blank">
                                                                            <i class="bi bi-printer"></i>
                                                                        </a>
                                                                    @endif
                                                                @break

                                                                @case('SKTM')
                                                                    @if ($surat->suratKeteranganTidakMampu)
                                                                        <a href="{{ route('sktm.print', $surat->suratKeteranganTidakMampu->id) }}"
                                                                            class="btn btn-sm btn-success" title="Print Surat"
                                                                            target="_blank">
                                                                            <i class="bi bi-printer"></i>
                                                                        </a>
                                                                    @endif
                                                                @break
                                                            @endswitch
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr id="emptyStateRow">
                                                    <td colspan="7" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                                            Belum ada riwayat pengajuan surat.
                                                            <br><a href="{{ route('verifikasi.index') }}"
                                                                class="btn btn-sm btn-outline-primary mt-2">
                                                                <i class="bi bi-plus-circle"></i> Ajukan Surat Baru
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if (method_exists($riwayatSurat, 'links'))
                                <div class="card-footer bg-white py-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <small class="text-muted">
                                            Total:
                                            {{ method_exists($riwayatSurat, 'total') ? $riwayatSurat->total() : $riwayatSurat->count() }}
                                            data
                                        </small>
                                        {{ $riwayatSurat->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Detail (Dinamis) -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Jenis Surat:</strong><br><span id="jenisSurat" class="text-muted"></span></p>
                                <p><strong>Tanggal Permintaan:</strong><br><span id="tanggalPermintaan"
                                        class="text-muted"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Nomor Surat:</strong><br><span id="nomorSurat" class="text-muted"></span></p>
                                <p><strong>Status Saat Ini:</strong><br><span id="statusSurat" class="text-muted"></span></p>
                                <p><strong>Bagian:</strong><br><span id="bagianSurat" class="text-muted"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Riwayat (Dinamis) -->
        <div class="modal fade" id="modalRiwayat" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Riwayat Status Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="riwayatLoading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat riwayat status...</p>
                        </div>
                        <div id="riwayatContent" style="display: none;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Bagian</th>
                                        <th width="120">Status</th>
                                        <th>Keterangan</th>
                                        <th width="140">Tanggal Proses</th>
                                        <th width="120">Petugas</th>
                                    </tr>
                                </thead>
                                <tbody id="riwayatStatusBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Modal Detail Handler
            const modalDetail = document.getElementById('modalDetail');
            modalDetail.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('jenisSurat').textContent = button.getAttribute('data-jenis');
                document.getElementById('tanggalPermintaan').textContent = button.getAttribute('data-tanggal');
                document.getElementById('nomorSurat').textContent = button.getAttribute('data-nomor') ||
                    'Belum diproses';
                document.getElementById('statusSurat').textContent = button.getAttribute('data-status');
                document.getElementById('bagianSurat').textContent = button.getAttribute('data-bagian') || 'Tata Usaha';
            });

            // Load Riwayat Status via AJAX
            function loadRiwayatStatus(permintaanSuratId) {
                const loading = document.getElementById('riwayatLoading');
                const content = document.getElementById('riwayatContent');
                const tbody = document.getElementById('riwayatStatusBody');

                // Show loading
                loading.style.display = 'block';
                content.style.display = 'none';
                tbody.innerHTML = '';

                // Fetch data
                fetch(`/riwayat-surat/${permintaanSuratId}/status`)
                    .then(response => response.json())
                    .then(data => {
                        loading.style.display = 'none';
                        content.style.display = 'block';

                        data.riwayat_status.forEach((item, index) => {
                            let badgeClass = 'secondary';
                            let iconClass = 'bi-clock';

                            switch (item.status) {
                                case 'Selesai':
                                    badgeClass = 'success';
                                    iconClass = 'bi-check-circle';
                                    break;
                                case 'Sedang Diproses':
                                    badgeClass = 'warning';
                                    iconClass = 'bi-hourglass-split';
                                    break;
                                case 'Ditolak':
                                    badgeClass = 'danger';
                                    iconClass = 'bi-x-circle';
                                    break;
                            }

                            const row = `<tr>
                                <td class="text-center">${index + 1}</td>
                                <td><strong>${item.bagian}</strong></td>
                                <td>
                                    <span class="badge bg-${badgeClass}">
                                        <i class="bi ${iconClass}"></i> ${item.status}
                                    </span>
                                </td>
                                <td><small>${item.keterangan}</small></td>
                                <td><small>${item.tanggal_proses || '-'}</small></td>
                                <td><small>${item.petugas}</small></td>
                            </tr>`;

                            tbody.insertAdjacentHTML('beforeend', row);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loading.style.display = 'none';
                        content.style.display = 'block';
                        tbody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-danger">Error memuat data riwayat</td></tr>';
                    });
            }

            // Reset modal saat ditutup
            document.getElementById('modalRiwayat').addEventListener('hidden.bs.modal', function() {
                document.getElementById('riwayatLoading').style.display = 'block';
                document.getElementById('riwayatContent').style.display = 'none';
            });
        </script>

        <style>
            #riwayatSuratTable tbody tr {
                transition: background-color .15s ease;
            }

            #riwayatSuratTable tbody tr:hover {
                background-color: #f8fafd;
            }

            #riwayat-surat .form-control:focus {
                box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);
            }
        </style>

        <script>
            (function() {
                const input = document.getElementById('searchRiwayat');
                if (!input) {
                    return;
                }
                const table = document.getElementById('riwayatSuratTable');
                const rows = () => table.querySelectorAll('tbody tr.data-row');
                const emptyStateServer = document.getElementById('emptyStateRow');

                function applyFilter() {
                    const term = input.value.trim().toLowerCase();
                    let visible = 0;

                    rows().forEach(row => {
                        const text = row.textContent.toLowerCase();
                        const match = text.includes(term);
                        row.style.display = match ? '' : 'none';
                        if (match) {
                            visible++;
                        }
                    });

                    if (!rows().length) {
                        return;
                    }

                    if (term && visible === 0) {
                        if (!document.getElementById('emptyStateClient')) {
                            const tr = document.createElement('tr');
                            tr.id = 'emptyStateClient';
                            tr.innerHTML = `<td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-search display-6 d-block mb-2"></i>
                                    Tidak ditemukan hasil untuk pencarian "<strong>${term}</strong>"
                                </div>
                            </td>`;
                            table.querySelector('tbody').appendChild(tr);
                        }
                    } else {
                        const clientEmpty = document.getElementById('emptyStateClient');
                        if (clientEmpty) {
                            clientEmpty.remove();
                        }
                    }

                    if (emptyStateServer) {
                        emptyStateServer.style.display = (rows().length === 0 || term) ? 'none' : '';
                    }
                }

                input.addEventListener('input', applyFilter);
            })();
        </script>
    @endsection
