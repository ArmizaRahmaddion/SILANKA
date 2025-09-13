@extends('layouts.dashboard-layouts', ['title' => 'Surat Keterangan Meninggal Dunia'])
@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Surat Keterangan Meninggal Dunia</h4>
                    </div>
                    {{-- @hasanyrole('staff-tu|superadmin')
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                Buat Surat Baru
                            </button>
                        @endhasanyrole --}}
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
                                    <th>Keperluan</th>
                                    <th>Nama Jenazah</th>
                                    <th>Tanggal Kematian</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($skkm as $datasurat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @php
                                            $suratTerbit = $datasurat->permintaanSurat->suratTerbit->first();
                                            $status = $datasurat->permintaanSurat->status;

                                            // Cek apakah sudah diajukan untuk verifikasi
                                            $sudahDiajukan = false;
                                            if ($suratTerbit) {
                                                $sudahDiajukan = \App\Models\VerifikasiSuratFinal::where(
                                                    'surat_terbit_id',
                                                    $suratTerbit->id,
                                                )->exists();
                                            }
                                        @endphp
                                        <td>
                                            @if ($suratTerbit)
                                                <strong>{{ $suratTerbit->nomor_surat }}</strong>
                                            @else
                                                <span class="text-muted">Belum Ada Nomor</span>
                                            @endif
                                        </td>
                                        <td>{{ $datasurat->keperluan ?? '-' }}</td>
                                        <td>{{ $datasurat->nama_almarhum ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($datasurat->tanggal_meninggal)->translatedFormat('d F Y') ?? '-' }}
                                        </td>
                                        <td>
                                            @switch($status)
                                                @case('Diproses')
                                                    <span class="badge bg-warning">{{ $status }}</span>
                                                @break

                                                @case('Diterima')
                                                    <span class="badge bg-info">{{ $status }}</span>
                                                    @if ($sudahDiajukan)
                                                        {{-- <br><small class="text-warning">Menunggu Verifikasi</small> --}}
                                                    @endif
                                                @break

                                                @case('Ditolak')
                                                    <span class="badge bg-danger">{{ $status }}</span>
                                                @break

                                                @case('Selesai')
                                                    <span class="badge bg-success">{{ $status }}</span>
                                                    {{-- <br><small class="text-success">Sudah Terverifikasi</small> --}}
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="d-flex gap-1">
                                            @if ($suratTerbit && in_array($status, ['Diterima', 'Selesai']))
                                                <!-- Button Print -->
                                                <a href="{{ route('skkm.print', $datasurat->id) }}"
                                                    class="btn btn-sm btn-info" title="Cetak Surat" target="_blank">
                                                    <i class="ri-printer-fill"></i>
                                                </a>

                                                <!-- Button Preview -->
                                                <a href="{{ route('surat.skkm.preview', $datasurat->id) }}"
                                                    class="btn btn-sm btn-info" target="_blank" title="Preview Surat">
                                                    <i class="ri-eye-fill"></i>
                                                </a>
                                            @else
                                                <!-- Button Print disabled jika belum ada surat terbit -->
                                                <button class="btn btn-sm btn-info" title="Surat belum diterbitkan"
                                                    disabled>
                                                    <i class="ri-printer-fill"></i>
                                                </button>
                                            @endif

                                            @hasanyrole('staff-tu|superadmin')
                                                @if ($status != 'Selesai')
                                                    <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal"
                                                        data-bs-target="#modalEditSurat{{ $datasurat->id }}">
                                                        <i class="ri-edit-fill"></i>
                                                    </button>

                                                    <!-- Modal Edit Surat -->
                                                    <div class="modal fade" id="modalEditSurat{{ $datasurat->id }}"
                                                        tabindex="-1" aria-labelledby="modalEditLabel{{ $datasurat->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form action="{{ route('surat.skkm.update', $datasurat->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalEditLabel{{ $datasurat->id }}">
                                                                            Edit Surat Keterangan Meninggal Dunia
                                                                            <span class="ms-2">
                                                                                <strong>{{ optional($suratTerbit)->nomor_surat ?? 'Belum Ada Nomor' }}</strong>
                                                                            </span>
                                                                        </h5>

                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body row g-3">
                                                                        <div class="col-md-6">
                                                                            <label for="nama_almarhum" class="form-label">Nama
                                                                                Almarhum</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama_almarhum"
                                                                                value="{{ $datasurat->nama_almarhum }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="nik_almarhum" class="form-label">NIK
                                                                                Almarhum</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nik_almarhum"
                                                                                value="{{ $datasurat->nik_almarhum }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tempat_lahir_almarhum"
                                                                                class="form-label">Tempat Lahir</label>
                                                                            <input type="text" class="form-control"
                                                                                name="tempat_lahir_almarhum"
                                                                                value="{{ $datasurat->tempat_lahir_almarhum }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tanggal_lahir_almarhum"
                                                                                class="form-label">Tanggal Lahir</label>
                                                                            <input type="date" class="form-control"
                                                                                name="tanggal_lahir_almarhum"
                                                                                value="{{ $datasurat->tanggal_lahir_almarhum->format('Y-m-d') }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="jenis_kelamin_almarhum"
                                                                                class="form-label">Jenis Kelamin</label>
                                                                            <select name="jenis_kelamin_almarhum"
                                                                                class="form-control" required>
                                                                                <option value="Laki-laki"
                                                                                    {{ $datasurat->jenis_kelamin_almarhum == 'Laki-laki' ? 'selected' : '' }}>
                                                                                    Laki-laki
                                                                                </option>
                                                                                <option value="Perempuan"
                                                                                    {{ $datasurat->jenis_kelamin_almarhum == 'Perempuan' ? 'selected' : '' }}>
                                                                                    Perempuan
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="agama_almarhum"
                                                                                class="form-label">Agama</label>
                                                                            <input type="text" class="form-control"
                                                                                name="agama_almarhum"
                                                                                value="{{ $datasurat->agama_almarhum }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="alamat_almarhum"
                                                                                class="form-label">Alamat</label>
                                                                            <textarea name="alamat_almarhum" class="form-control" rows="2" required>{{ $datasurat->alamat_almarhum }}</textarea>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tanggal_meninggal"
                                                                                class="form-label">Tanggal
                                                                                Meninggal</label>
                                                                            <input type="date" class="form-control"
                                                                                name="tanggal_meninggal"
                                                                                value="{{ $datasurat->tanggal_meninggal->translatedFormat('Y-m-d') }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="keperluan"
                                                                                class="form-label">Keperluan</label>
                                                                            <input type="text" class="form-control"
                                                                                name="keperluan"
                                                                                value="{{ $datasurat->keperluan }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="ri-save-line"></i> Simpan Perubahan
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <button class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="confirmDelete({{ $datasurat->id }})">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                @endif


                                                @if ($status === 'Diterima' && !$sudahDiajukan)
                                                    <!-- Tombol Ajukan TTD - hanya muncul jika belum diajukan -->
                                                    @php
                                                        $kodeSurat =
                                                            $datasurat->permintaanSurat->jenisSurat->kode_surat;
                                                    @endphp

                                                    <button class="btn btn-sm btn-primary" title="Ajukan Tanda Tangan Digital"
                                                        onclick="confirmAjukanTtd({{ $datasurat->id }}, '{{ $kodeSurat }}', '{{ $suratTerbit->nomor_surat }}')">
                                                        <i class="ri-quill-pen-line"></i> Ajukan TTD
                                                    </button>
                                                @elseif ($status === 'Diterima' && $sudahDiajukan)
                                                    <!-- Status sudah diajukan -->
                                                    <span class="btn btn-sm btn-outline-warning" disabled>
                                                        <i class="ri-time-line"></i> Menunggu Verifikasi
                                                    </span>
                                                @elseif ($status === 'Selesai')
                                                    <!-- Status sudah selesai -->
                                                    <span class="btn btn-sm btn-outline-success" disabled>
                                                        <i class="ri-check-double-line"></i> Terverifikasi
                                                    </span>
                                                @endif
                                            @endhasanyrole
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Ajukan TTD -->
    <div class="modal fade" id="modalAjukanTtd" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengajuan Tanda Tangan Digital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengajukan tanda tangan digital untuk surat:</p>
                    <p><strong id="nomorSuratTtd"></strong></p>
                    <div class="alert alert-warning">
                        <i class="ri-information-line"></i>
                        Surat akan dikirim ke sekretaris untuk proses verifikasi dan penandatanganan digital.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="formAjukanTtd" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="ri-quill-pen-line"></i> Ya, Ajukan TTD
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Implementasi delete
                console.log('Delete ID:', id);
            }
        }

        function confirmAjukanTtd(id, kodeSurat, nomorSurat) {
            document.getElementById('nomorSuratTtd').textContent = nomorSurat;
            document.getElementById('formAjukanTtd').action = `/${kodeSurat}/${id}/ajukan-ttd`;

            var modal = new bootstrap.Modal(document.getElementById('modalAjukanTtd'));
            modal.show();
        }


        // Auto close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endsection
