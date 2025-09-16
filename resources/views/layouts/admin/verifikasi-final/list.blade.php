@extends('layouts.dashboard-layouts', ['title' => 'Verifikasi Surat'])

@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Menunggu Verifikasi</h4>
                        <p class="text-muted mb-0">Daftar surat yang menunggu verifikasi dan tanda tangan digital</p>
                    </div>
                    <div>
                        <a href="{{ route('verifikasi.verified') }}" class="btn btn-sm btn-success me-2">
                            <i class="ri-check-double-line"></i> Lihat Surat Terverifikasi
                        </a>
                        <span class="badge bg-{{ $verifikasiSurat->count() > 0 ? 'warning' : 'secondary' }} py-2 px-3">
                            {{ $verifikasiSurat->count() }} Menunggu
                        </span>
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
                                    <th>Tanggal Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($verifikasiSurat as $verifikasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $verifikasi->suratTerbit?->nomor_surat ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            {{ $verifikasi->jenisSurat?->nama_surat ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $verifikasi->created_at->format('d/m/Y H:i') }}
                                            <br>
                                            <small class="text-muted">{{ $verifikasi->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @switch($verifikasi->jenisSurat?->kode_surat)
                                                    @case('SKKM')
                                                        @if ($verifikasi->permintaanSurat->suratKeteranganMeninggalDunia)
                                                            <a href="{{ route('skkm.preview', $verifikasi->permintaanSurat->suratKeteranganMeninggalDunia->id) }}"
                                                                class="btn btn-sm btn-info" title="Preview Surat" target="_blank">
                                                                <i class="ri-eye-fill"></i>
                                                            </a>
                                                        @endif
                                                    @break

                                                    @case('SKD')
                                                        @if ($verifikasi->permintaanSurat->suratKeteranganDomisili)
                                                            <a href="{{ route('skd.preview', $verifikasi->permintaanSurat->suratKeteranganDomisili->id) }}"
                                                                class="btn btn-sm btn-info" title="Preview Surat" target="_blank">
                                                                <i class="ri-eye-fill"></i>
                                                            </a>
                                                        @endif
                                                    @break

                                                    @case('SKU')
                                                        @if ($verifikasi->permintaanSurat->suratKeteranganUsaha)
                                                            <a href="{{ route('sku.preview', $verifikasi->permintaanSurat->suratKeteranganUsaha->id) }}"
                                                                class="btn btn-sm btn-info" title="Preview Surat" target="_blank">
                                                                <i class="ri-eye-fill"></i>
                                                            </a>
                                                        @endif
                                                    @break

                                                    @case('SKTM')
                                                        @if ($verifikasi->permintaanSurat->suratKeteranganTidakMampu)
                                                            <a href="{{ route('sktm.preview', $verifikasi->permintaanSurat->suratKeteranganTidakMampu->id) }}"
                                                                class="btn btn-sm btn-info" title="Preview Surat" target="_blank">
                                                                <i class="ri-eye-fill"></i>
                                                            </a>
                                                        @endif
                                                    @break

                                                    @default
                                                        <span class="text-muted">Jenis surat tidak dikenali</span>
                                                @endswitch

                                                <button class="btn btn-sm btn-success" title="Verifikasi & Generate Barcode"
                                                    onclick="confirmVerifikasi({{ $verifikasi->id }}, '{{ $verifikasi->suratTerbit?->nomor_surat }}')">
                                                    <i class="ri-check-double-line"></i> Verifikasi
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                <div class="py-4">
                                                    <i class="ri-file-list-3-line" style="font-size: 48px; color: #ccc;"></i>
                                                    <p class="text-muted mt-2">Tidak ada surat yang menunggu verifikasi</p>
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

        <!-- Modal Konfirmasi Verifikasi -->
        <div class="modal fade" id="modalVerifikasi" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Verifikasi Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memverifikasi surat dengan nomor:</p>
                        <p><strong id="nomorSuratVerifikasi"></strong></p>
                        <div class="alert alert-info">
                            <i class="ri-information-line"></i>
                            Setelah diverifikasi, sistem akan:
                            <ul class="mb-0 mt-2">
                                <li>Generate barcode unik untuk surat</li>
                                <li>Mengubah status surat menjadi "Selesai"</li>
                                <li>Surat siap untuk dicetak dengan QR Code</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form id="formVerifikasi" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="ri-check-double-line"></i> Ya, Verifikasi Surat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function confirmVerifikasi(id, nomorSurat) {
                document.getElementById('nomorSuratVerifikasi').textContent = nomorSurat;
                document.getElementById('formVerifikasi').action = `/${id}/verifikasi`;

                var modal = new bootstrap.Modal(document.getElementById('modalVerifikasi'));
                modal.show();
            }

            // Auto close alerts after 10 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 10000);
        </script>
    @endsection
