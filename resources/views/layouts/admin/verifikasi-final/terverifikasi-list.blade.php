@extends('layouts.dashboard-layouts')
@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Surat Terverifikasi</h4>
                            <p class="text-muted mb-0">Daftar surat yang telah diverifikasi dengan tanda tangan digital</p>
                        </div>
                        <div>
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-sm btn-warning me-2">
                                <i class="ri-time-line"></i> Menunggu Verifikasi
                            </a>
                            <span class="badge bg-success">{{ $verifikasiSurat->count() }} Terverifikasi</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nomor Surat</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal Verifikasi</th>
                                        <th>Diverifikasi Oleh</th>
                                        <th>Status Barcode</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($verifikasiSurat as $verifikasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $verifikasi->suratTerbit->nomor_surat ?? '-' }}</strong>
                                            </td>
                                            <td>
                                                {{ $verifikasi->jenisSurat->nama_surat ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $verifikasi->verified_at->format('d/m/Y H:i') }}
                                                <br><small
                                                    class="text-muted">{{ $verifikasi->verified_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-title bg-primary rounded-circle">
                                                            {{ substr($verifikasi->verifiedBy->name ?? 'S', 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <small
                                                            class="fw-bold">{{ $verifikasi->verifiedBy->name ?? 'System' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($verifikasi->barcode)
                                                    <span class="badge bg-success">
                                                        <i class="ri-qr-code-line"></i> Tersedia
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="ri-close-line"></i> Tidak Ada
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <!-- Preview Surat dengan Barcode -->
                                                    @php
                                                        $kodeSurat = $verifikasi->jenisSurat->kode_surat;
                                                        $permintaan = $verifikasi->permintaanSurat;
                                                    @endphp

                                                    <!-- Preview Surat dengan Barcode -->
                                                    @switch($kodeSurat)
                                                        @case('SKKM')
                                                            @if ($permintaan->suratKeteranganMeninggalDunia)
                                                                <a href="{{ route('surat.skkm.preview', $permintaan->suratKeteranganMeninggalDunia->id) }}"
                                                                    class="btn btn-sm btn-success" title="Preview dengan Barcode"
                                                                    target="_blank">
                                                                    <i class="ri-eye-fill"></i> Preview
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKD')
                                                            @if ($permintaan->suratKeteranganDomisili)
                                                                <a href="{{ route('surat.skd.preview', $permintaan->suratKeteranganDomisili->id) }}"
                                                                    class="btn btn-sm btn-success" title="Preview dengan Barcode"
                                                                    target="_blank">
                                                                    <i class="ri-eye-fill"></i> Preview
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKU')
                                                            @if ($permintaan->suratKeteranganUsaha)
                                                                <a href="{{ route('surat.sku.preview', $permintaan->suratKeteranganUsaha->id) }}"
                                                                    class="btn btn-sm btn-success" title="Preview dengan Barcode"
                                                                    target="_blank">
                                                                    <i class="ri-eye-fill"></i> Preview
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKTM')
                                                            @if ($permintaan->suratKeteranganTidakMampu)
                                                                <a href="{{ route('surat.sktm.preview', $permintaan->suratKeteranganTidakMampu->id) }}"
                                                                    class="btn btn-sm btn-success" title="Preview dengan Barcode"
                                                                    target="_blank">
                                                                    <i class="ri-eye-fill"></i> Preview
                                                                </a>
                                                            @endif
                                                        @break

                                                        @default
                                                            <span class="text-muted">Jenis surat tidak dikenali</span>
                                                    @endswitch


                                                    <!-- Print Surat dengan Barcode -->
                                                    @php
                                                        $kodeSurat = $verifikasi->jenisSurat->kode_surat;
                                                        $permintaan = $verifikasi->permintaanSurat;
                                                    @endphp

                                                    @switch($kodeSurat)
                                                        @case('SKKM')
                                                            @if ($permintaan->suratKeteranganMeninggalDunia)
                                                                <a href="{{ route('skkm.print', $permintaan->suratKeteranganMeninggalDunia->id) }}"
                                                                    class="btn btn-sm btn-primary" title="Print Surat"
                                                                    target="_blank">
                                                                    <i class="ri-printer-line"></i> Print
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKD')
                                                            @if ($permintaan->suratKeteranganDomisili)
                                                                <a href="{{ route('skd.print', $permintaan->suratKeteranganDomisili->id) }}"
                                                                    class="btn btn-sm btn-primary" title="Print Surat"
                                                                    target="_blank">
                                                                    <i class="ri-printer-line"></i> Print
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKU')
                                                            @if ($permintaan->suratKeteranganUsaha)
                                                                <a href="{{ route('sku.print', $permintaan->suratKeteranganUsaha->id) }}"
                                                                    class="btn btn-sm btn-primary" title="Print Surat"
                                                                    target="_blank">
                                                                    <i class="ri-printer-line"></i> Print
                                                                </a>
                                                            @endif
                                                        @break

                                                        @case('SKTM')
                                                            @if ($permintaan->suratKeteranganTidakMampu)
                                                                <a href="{{ route('sktm.print', $permintaan->suratKeteranganTidakMampu->id) }}"
                                                                    class="btn btn-sm btn-primary" title="Print Surat"
                                                                    target="_blank">
                                                                    <i class="ri-printer-line"></i> Print
                                                                </a>
                                                            @endif
                                                        @break

                                                        @default
                                                            <span class="text-muted">Jenis surat tidak dikenali</span>
                                                    @endswitch


                                                    <!-- Download Barcode -->
                                                    @if ($verifikasi->barcode)
                                                        <a href="{{ asset('storage/' . $verifikasi->barcode) }}"
                                                            class="btn btn-sm btn-info" title="Download Barcode" download>
                                                            <i class="ri-download-line"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="7">
                                                    <div class="py-4">
                                                        <i class="ri-shield-check-line"
                                                            style="font-size: 48px; color: #ccc;"></i>
                                                        <p class="text-muted mt-2">Belum ada surat yang terverifikasi</p>
                                                        <a href="{{ route('verifikasi.index') }}"
                                                            class="btn btn-outline-warning">
                                                            <i class="ri-time-line"></i> Lihat Surat Menunggu Verifikasi
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Auto close alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
    @endsection
