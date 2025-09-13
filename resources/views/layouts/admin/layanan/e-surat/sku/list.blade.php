@extends('layouts.dashboard-layouts', ['title' => 'Surat Keterangan Usaha'])
@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Surat Keterangan Usaha</h4>
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
                                    <th>Nama</th>
                                    <th>Nik</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jenis Usaha</th>
                                    <th>Luas Usaha</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sku as $datasurat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @php
                                            $suratTerbit = $datasurat->permintaanSurat->suratTerbit->first();
                                            $status = $datasurat->permintaanSurat->status;
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
                                        <td>{{ $datasurat->nama ?? '-' }}</td>
                                        <td>{{ $datasurat->nik ?? '-' }}</td>
                                        <td>{{ $datasurat->jenis_kelamin ?? '-' }}</td>
                                        <td>{{ $datasurat->jenis_usaha ?? '-' }}</td>
                                        <td>
                                            {{ $datasurat->luas_usaha ?? '-' }}
                                            <span style="margin-left: 4px;">Ha</span>
                                        </td>
                                        <td>
                                            @switch($status)
                                                @case('Diproses')
                                                    <span class="badge bg-warning">{{ $status }}</span>
                                                @break

                                                @case('Diterima')
                                                    <span class="badge bg-info">{{ $status }}</span>
                                                @break

                                                @case('Ditolak')
                                                    <span class="badge bg-danger">{{ $status }}</span>
                                                @break

                                                @case('Selesai')
                                                    <span class="badge bg-success">{{ $status }}</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="d-flex gap-1">
                                            @if ($suratTerbit && in_array($status, ['Diterima', 'Selesai']))
                                                <a href="{{ route('sku.print', $datasurat->id) }}"
                                                    class="btn btn-sm btn-info" title="Cetak Surat" target="_blank">
                                                    <i class="ri-printer-fill"></i>
                                                </a>
                                                <a href="{{ route('surat.sku.preview', $datasurat->id) }}"
                                                    class="btn btn-sm btn-info" target="_blank" title="Preview Surat">
                                                    <i class="ri-eye-fill"></i>
                                                </a>
                                            @else
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
                                                    <div class="modal fade" id="modalEditSurat{{ $datasurat->id }}"
                                                        tabindex="-1" aria-labelledby="modalEditLabel{{ $datasurat->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form action="{{ route('surat.sku.update', $datasurat->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalEditLabel{{ $datasurat->id }}">
                                                                            Edit Surat Keterangan Usaha
                                                                            @if ($suratTerbit)
                                                                                <span
                                                                                    class="ms-2"><strong>{{ $suratTerbit->nomor_surat }}</strong></span>
                                                                            @else
                                                                                <span class="ms-2 text-muted"><strong>(Belum
                                                                                        Terbit)</strong></span>
                                                                            @endif
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body row g-3">
                                                                        <div class="col-md-6">
                                                                            <label for="nama" class="form-label">Nama <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama" value="{{ $datasurat->nama }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="nik" class="form-label">Nomor Induk
                                                                                Kependudukan <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="nik" value="{{ $datasurat->nik }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tempat_lahir" class="form-label">Tempat
                                                                                Lahir <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="tempat_lahir"
                                                                                value="{{ $datasurat->tempat_lahir }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tanggal_lahir"
                                                                                class="form-label">Tanggal Lahir <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control"
                                                                                name="tanggal_lahir"
                                                                                value="{{ \Carbon\Carbon::parse($datasurat->tanggal_lahir)->translatedFormat('Y-m-d') }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="status_perkawinan"
                                                                                class="form-label">Status Perkawinan <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="status_perkawinan"
                                                                                id="status_perkawinan" class="form-control"
                                                                                required>
                                                                                <option value="">Pilih</option>
                                                                                <option value="Belum Kawin"
                                                                                    {{ $datasurat->status_perkawinan == 'Belum Kawin' ? 'selected' : '' }}>
                                                                                    Belum Kawin</option>
                                                                                <option value="Kawin"
                                                                                    {{ $datasurat->status_perkawinan == 'Kawin' ? 'selected' : '' }}>
                                                                                    Kawin</option>
                                                                                <option value="Cerai Hidup"
                                                                                    {{ $datasurat->status_perkawinan == 'Cerai Hidup' ? 'selected' : '' }}>
                                                                                    Cerai Hidup</option>
                                                                                <option value="Cerai Mati"
                                                                                    {{ $datasurat->status_perkawinan == 'Cerai Mati' ? 'selected' : '' }}>
                                                                                    Cerai Mati</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="jenis_kelamin"
                                                                                class="form-label">Jenis Kelamin <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="jenis_kelamin" class="form-control"
                                                                                required>
                                                                                <option value="" disabled
                                                                                    {{ $datasurat->jenis_kelamin == '' ? 'selected' : '' }}>
                                                                                    Pilih</option>
                                                                                <option value="Laki-laki"
                                                                                    {{ $datasurat->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                                                    Laki-laki</option>
                                                                                <option value="Perempuan"
                                                                                    {{ $datasurat->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                                                    Perempuan</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="agama" class="form-label">Agama
                                                                                <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="agama"
                                                                                value="{{ $datasurat->agama }}" required>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="alamat" class="form-label">Alamat
                                                                                <span class="text-danger">*</span></label>
                                                                            <select name="alamat" class="form-control"
                                                                                required>
                                                                                <option value="" disabled
                                                                                    {{ old('alamat') == '' ? 'selected' : '' }}>
                                                                                    Pilih</option>
                                                                                <option value="Simpang Tiga"
                                                                                    {{ $datasurat->alamat == 'Simpang Tiga' ? 'selected' : '' }}>
                                                                                    Simpang Tiga</option>
                                                                                <option value="Koto Ronah"
                                                                                    {{ $datasurat->alamat == 'Koto Ronah' ? 'selected' : '' }}>
                                                                                    Koto Ronah</option>
                                                                                <option value="Koto Tangah"
                                                                                    {{ $datasurat->alamat == 'Koto Tangah' ? 'selected' : '' }}>
                                                                                    Koto Tangah</option>
                                                                                <option value="Polong Duo"
                                                                                    {{ $datasurat->alamat == 'Polong Duo' ? 'selected' : '' }}>
                                                                                    Polong Duo</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="pekerjaan"
                                                                                class="form-label">Pekerjaan <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="pekerjaan"
                                                                                value="{{ $datasurat->pekerjaan }}" required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="jenis_usaha" class="form-label">Jenis
                                                                                Usaha <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="jenis_usaha"
                                                                                value="{{ $datasurat->jenis_usaha }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="luas_usaha" class="form-label">Luas
                                                                                Usaha <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="luas_usaha"
                                                                                value="{{ $datasurat->luas_usaha }}" required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="keperluan"
                                                                                class="form-label">Keperluan <span
                                                                                    class="text-danger">*</span></label>
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

                                                    <button class="btn btn-sm btn-danger" title="Hapus"
                                                        onclick="confirmDelete({{ $datasurat->id }})">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                @endif

                                                @if ($status === 'Diterima' && $suratTerbit && !$sudahDiajukan)
                                                    @php
                                                        $kodeSurat =
                                                            $datasurat->permintaanSurat->jenisSurat->kode_surat;
                                                    @endphp
                                                    <button class="btn btn-sm btn-primary" title="Ajukan Tanda Tangan Digital"
                                                        onclick="confirmAjukanTtd({{ $datasurat->id }}, '{{ $kodeSurat }}', '{{ $suratTerbit->nomor_surat }}')">
                                                        <i class="ri-quill-pen-line"></i> Ajukan TTD
                                                    </button>
                                                @elseif ($status === 'Diterima' && $sudahDiajukan)
                                                    <span class="btn btn-sm btn-outline-warning" disabled>
                                                        <i class="ri-time-line"></i> Menunggu Verifikasi
                                                    </span>
                                                @elseif ($status === 'Selesai')
                                                    <span class="btn btn-sm btn-outline-success" disabled>
                                                        <i class="ri-check-double-line"></i> Terverifikasi
                                                    </span>
                                                @endif
                                            @endhasanyrole
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalDelete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="formDelete" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
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
            const form = document.getElementById('formDelete');
            // Assuming your delete route is something like /surat/sku/{id}
            form.action = `/surat/sku/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('modalDelete'));
            deleteModal.show();
        }

        function confirmAjukanTtd(id, kodeSurat, nomorSurat) {
            document.getElementById('nomorSuratTtd').textContent = nomorSurat;
            const form = document.getElementById('formAjukanTtd');
            // Assuming your TTD route is something like /sku/{id}/ajukan-ttd
            form.action = `/surat/${kodeSurat}/${id}/ajukan-ttd`;
            const ttdModal = new bootstrap.Modal(document.getElementById('modalAjukanTtd'));
            ttdModal.show();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bootstrapAlert.close();
                }, 5000);
            });
        });
    </script>
@endsection
