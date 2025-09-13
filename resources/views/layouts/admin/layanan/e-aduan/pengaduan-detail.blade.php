@extends('layouts.dashboard-layouts', ['title' => 'Detail Pengaduan'])

@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row">
            <!-- Header Card -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-primary text-white rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title text-white mb-1">
                                    <i class="fas fa-clipboard-list me-2"></i>Detail Pengaduan
                                </h4>
                                <p class="mb-0 opacity-75">Informasi lengkap pengaduan dari masyarakat</p>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <!-- Informasi Pengaduan -->
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>Informasi Pengaduan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">TANGGAL PENGADUAN</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        {{ \Carbon\Carbon::parse($pengaduan->tanggal)->format('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">KATEGORI</label>
                                    <div class="p-2 bg-light rounded">
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $pengaduan->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">ISI PENGADUAN</label>
                            <div class="p-3 bg-light rounded border-start border-primary border-4">
                                <div class="text-justify" style="line-height: 1.6;">
                                    {{ $pengaduan->pengaduan }}
                                </div>
                            </div>
                        </div>

                        @if ($pengaduan->file)
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">LAMPIRAN</label>
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Dokumen Lampiran</h6>
                                            <small class="text-muted">File pendukung pengaduan</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="{{ asset('storage/' . $pengaduan->file) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Lihat File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="col-lg-4 mb-4">
                <!-- Data Pengadu -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user text-success me-2"></i>Data Pengadu
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user text-success fa-2x"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">NAMA LENGKAP</label>
                            <div class="p-2 bg-light rounded">
                                {{ $pengaduan->verifikasi->nama_lengkap ?? 'Tidak Diketahui' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">NIK</label>
                            <div class="p-2 bg-light rounded font-monospace">
                                {{ $pengaduan->verifikasi->nik ?? 'Tidak Diketahui' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">NOMOR TELEPON</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-phone text-success me-2"></i>
                                {{ $pengaduan->verifikasi->no_hp ?? 'Tidak Diketahui' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">ALAMAT</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <small>{{ $pengaduan->verifikasi->alamat ?? 'Tidak Diketahui' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status & Waktu -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock text-warning me-2"></i>Informasi Sistem
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">WAKTU DIBUAT</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-calendar-check text-info me-2"></i>
                                <small>{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">TERAKHIR DIUPDATE</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-sync-alt text-warning me-2"></i>
                                <small>{{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB</small>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold text-muted small">ID PENGADUAN</label>
                            <div class="p-2 bg-light rounded font-monospace">
                                <i class="fas fa-hashtag text-secondary me-2"></i>
                                #{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Cetak Detail
                                </button>

                                @if ($pengaduan->file)
                                    <a href="{{ asset('storage/' . $pengaduan->file) }}" download
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-download me-1"></i>Unduh Lampiran
                                    </a>
                                @endif
                            </div>

                            <div class="text-muted small">
                                <i class="fas fa-eye me-1"></i>
                                Dilihat pada {{ now()->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            .card-header,
            .bg-primary {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }
        }

        .text-justify {
            text-align: justify;
        }

        .border-start {
            border-left: 4px solid var(--bs-primary) !important;
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
    </style>
@endsection
