@extends('layouts.dashboard-layouts', ['title' => 'Daftar Pengaduan'])

@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Daftar Pengaduan</h4>
                </div>
                <div class="card-body">
                    @if ($pengaduan->isEmpty())
                        <div class="alert alert-danger text-center">
                            Belum ada pengaduan yang masuk.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pengguna</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Isi Pengaduan</th>
                                        <th>Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->verifikasi->nama_lengkap ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                            <td>{{ Str::limit($item->pengaduan, 100) }}</td>
                                            <td>
                                                @if ($item->file)
                                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-file-alt me-1"></i>Lihat File
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('pengaduan.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                        title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
