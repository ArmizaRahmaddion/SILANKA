@extends('layouts.dashboard-layouts', ['title' => 'Permintaan Surat'])
@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Permintaan Surat</h4>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Status</th>
                                    <th>Jenis Surat</th>
                                    <th>Nama & Nik Pemohon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permintaanSurats as $permintaan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permintaan->tanggal_permintaan->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                                    @if ($permintaan->status === 'Diproses') bg-warning
                                                    @elseif($permintaan->status === 'Selesai') bg-success
                                                    @elseif($permintaan->status === 'Diterima') bg-info
                                                    @elseif($permintaan->status === 'Ditolak') bg-danger
                                                    @else bg-secondary @endif py-2 px-1 text-capitalize">
                                                {{ $permintaan->status }}
                                            </span>
                                        </td>
                                        <td>{{ $permintaan->jenisSurat->nama_surat ?? '-' }}</td>
                                        <td>
                                            <br>
                                            <strong>{{ $permintaan->verifikasiPengguna->nama_lengkap ?? '-' }} </strong>
                                            <br><small
                                                class="text-info">{{ $permintaan->verifikasiPengguna->nik ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @hasanyrole('staff-tu|superadmin')
                                                @if ($permintaan->status === 'Diproses')
                                                    <a href="{{ route('permintaan-surat.buat-surat', $permintaan->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Buat Surat
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada aksi</span>
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
@endsection
