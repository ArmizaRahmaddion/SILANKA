@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>RIWAYAT PENGADUAN</h1>
                        <p class="mb-0">Pantau status dan riwayat pengaduan Anda dengan mudah.
                            Lihat detail dan perkembangan setiap pengaduan yang telah Anda ajukan.</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="#">Beranda</a></li>
                    <li class="current">Riwayat Pengaduan</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <section id="riwayat-pengaduan" class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-white d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="bi bi-chat-square-text me-2 text-primary"></i> Riwayat Pengaduan
                                </h5>
                                <p class="mb-0 text-muted small">
                                    Lacak status, detail, dan progres setiap pengaduan yang Anda ajukan.
                                </p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchRiwayat" class="form-control"
                                        placeholder="Cari kategori / tanggal / isi pengaduan...">
                                </div>
                                <div class="d-flex align-items-center gap-2 small flex-wrap">
                                    <span class="badge bg-info">Diterima</span>
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                    <span class="badge bg-success">Selesai</span>
                                    <span class="badge bg-danger">Ditolak</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="riwayatPengaduanTable" class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:60px;">No.</th>
                                            <th style="min-width:140px;">Tanggal Pengaduan</th>
                                            <th style="min-width:200px;">Kategori</th>
                                            <th style="min-width:250px;">Isi Pengaduan</th>
                                            <th style="min-width:100px;">File</th>
                                            <th style="min-width:120px;">Status</th>
                                            <th style="min-width:120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayatPengaduan as $pengaduan)
                                            <tr class="data-row">
                                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="text-nowrap">
                                                        {{ \Carbon\Carbon::parse($pengaduan->tanggal)->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td>{{ $pengaduan->kategori->nama_kategori ?? '—' }}</td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;"
                                                        title="{{ $pengaduan->pengaduan }}">
                                                        {{ Str::limit($pengaduan->pengaduan, 50) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($pengaduan->file)
                                                        <a href="{{ asset('storage/pengaduan/' . $pengaduan->file) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-file-earmark"></i> Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        // Status dummy berdasarkan tanggal (untuk demo)
                                                        $days = \Carbon\Carbon::parse($pengaduan->tanggal)->diffInDays(
                                                            now(),
                                                        );
                                                        if ($days <= 1) {
                                                            $status = 'Diterima';
                                                            $badgeClass = 'info';
                                                        } elseif ($days <= 7) {
                                                            $status = 'Diproses';
                                                            $badgeClass = 'warning';
                                                        } elseif ($days <= 14) {
                                                            $status = 'Selesai';
                                                            $badgeClass = 'success';
                                                        } else {
                                                            $status = 'Selesai';
                                                            $badgeClass = 'success';
                                                        }
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeClass }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#modalDetail"
                                                        data-id="{{ $pengaduan->id }}"
                                                        data-kategori="{{ $pengaduan->kategori->nama_kategori ?? '—' }}"
                                                        data-tanggal="{{ \Carbon\Carbon::parse($pengaduan->tanggal)->format('d M Y') }}"
                                                        data-pengaduan="{{ $pengaduan->pengaduan }}"
                                                        data-file="{{ $pengaduan->file }}"
                                                        data-status="{{ $status }}">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="emptyStateRow">
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="bi bi-chat-square-text display-6 d-block mb-2"></i>
                                                        Belum ada pengaduan yang diajukan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if (method_exists($riwayatPengaduan, 'links'))
                            <div class="card-footer bg-white py-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <small class="text-muted">
                                        Total:
                                        {{ method_exists($riwayatPengaduan, 'total') ? $riwayatPengaduan->total() : $riwayatPengaduan->count() }}
                                        data
                                    </small>
                                    {{ $riwayatPengaduan->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Pengaduan -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-chat-square-text me-2"></i>Detail Pengaduan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="bi bi-info-circle me-1"></i>Informasi Pengaduan
                                    </h6>
                                    <div class="mb-2">
                                        <strong>Kategori:</strong> <span id="kategoriPengaduan"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Tanggal:</strong> <span id="tanggalPengaduan"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Status:</strong> <span id="statusPengaduan"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>File Lampiran:</strong>
                                        <div id="filePengaduan"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-success">
                                        <i class="bi bi-chat-text me-1"></i>Isi Pengaduan
                                    </h6>
                                    <div class="border rounded p-3 bg-light">
                                        <p id="isiPengaduan" class="mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Status -->
                    <div class="mt-4">
                        <h6 class="text-primary">
                            <i class="bi bi-clock-history me-1"></i>Timeline Status
                        </h6>
                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Pengaduan Diterima</h6>
                                    <p class="text-muted mb-0">Pengaduan Anda telah diterima dan sedang diverifikasi</p>
                                    <small class="text-muted" id="tanggalDiterima"></small>
                                </div>
                            </div>
                            <div class="timeline-item" id="timelineProses">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Sedang Diproses</h6>
                                    <p class="text-muted mb-0">Pengaduan sedang ditindaklanjuti oleh petugas terkait</p>
                                    <small class="text-muted">Estimasi 3-7 hari kerja</small>
                                </div>
                            </div>
                            <div class="timeline-item" id="timelineSelesai">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Selesai Ditindaklanjuti</h6>
                                    <p class="text-muted mb-0">Pengaduan telah selesai ditindaklanjuti</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #riwayatPengaduanTable tbody tr {
            transition: background-color .15s ease;
        }

        #riwayatPengaduanTable tbody tr:hover {
            background-color: #f8fafd;
        }

        #riwayat-pengaduan .form-control:focus {
            box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -23px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e9ecef;
        }

        .timeline-item.active .timeline-marker {
            box-shadow: 0 0 0 2px #28a745;
        }

        .timeline-content h6 {
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .timeline-content p {
            font-size: 0.85rem;
            margin-bottom: 2px;
        }

        .timeline-content small {
            font-size: 0.75rem;
        }
    </style>

    <script>
        // Modal Detail Event
        const modalDetail = document.getElementById('modalDetail');
        modalDetail.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            // Set data ke modal
            document.getElementById('kategoriPengaduan').textContent = button.getAttribute('data-kategori');
            document.getElementById('tanggalPengaduan').textContent = button.getAttribute('data-tanggal');
            document.getElementById('isiPengaduan').textContent = button.getAttribute('data-pengaduan');

            // Set status dengan badge
            const status = button.getAttribute('data-status');
            const statusElement = document.getElementById('statusPengaduan');
            let badgeClass = 'secondary';
            switch (status) {
                case 'Diterima':
                    badgeClass = 'info';
                    break;
                case 'Diproses':
                    badgeClass = 'warning';
                    break;
                case 'Selesai':
                    badgeClass = 'success';
                    break;
                case 'Ditolak':
                    badgeClass = 'danger';
                    break;
            }
            statusElement.innerHTML = `<span class="badge bg-${badgeClass}">${status}</span>`;

            // Set file
            const file = button.getAttribute('data-file');
            const fileElement = document.getElementById('filePengaduan');
            if (file) {
                fileElement.innerHTML = `<a href="/storage/pengaduan/${file}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-download me-1"></i>Unduh File
                </a>`;
            } else {
                fileElement.innerHTML = '<span class="text-muted">Tidak ada file</span>';
            }

            // Set timeline based on status
            const timelineProses = document.getElementById('timelineProses');
            const timelineSelesai = document.getElementById('timelineSelesai');

            // Reset timeline
            timelineProses.classList.remove('active');
            timelineSelesai.classList.remove('active');

            if (status === 'Diproses' || status === 'Selesai') {
                timelineProses.classList.add('active');
            }
            if (status === 'Selesai') {
                timelineSelesai.classList.add('active');
            }

            // Set tanggal diterima
            document.getElementById('tanggalDiterima').textContent = button.getAttribute('data-tanggal');
        });

        // Search functionality
        (function() {
            const input = document.getElementById('searchRiwayat');
            if (!input) {
                return;
            }
            const table = document.getElementById('riwayatPengaduanTable');
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
