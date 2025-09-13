@extends('layouts.dashboard-layouts')

@section('title', 'Kelola Kop Surat')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Kelola Kop Surat</h3>
                        <a href="{{ route('kop-surat.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kop Surat
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Nama Instansi</th>
                                        <th>Alamat</th>
                                        <th>Kontak</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kopSurat as $index => $kop)
                                        <tr>
                                            <td>{{ $kopSurat->firstItem() + $index }}</td>
                                            <td>
                                                @if ($kop->logo)
                                                    <img src="{{ Storage::url($kop->logo) }}" alt="Logo"
                                                        class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                @else
                                                    <span class="text-muted">Tidak ada logo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $kop->nama_instansi }}</strong>
                                                @if ($kop->nama_instansi_2)
                                                    <br><small>{{ $kop->nama_instansi_2 }}</small>
                                                @endif
                                                @if ($kop->nama_instansi_3)
                                                    <br><small>{{ $kop->nama_instansi_3 }}</small>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($kop->alamat, 50) }}</td>
                                            <td>
                                                @if ($kop->telepon)
                                                    <div><i class="fas fa-phone"></i> {{ $kop->telepon }}</div>
                                                @endif
                                                @if ($kop->email)
                                                    <div><i class="fas fa-envelope"></i> {{ $kop->email }}</div>
                                                @endif
                                                @if ($kop->kode_pos)
                                                    <div><i class="fas fa-map-marker-alt"></i> {{ $kop->kode_pos }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($kop->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('kop-surat.show', $kop) }}"
                                                        class="btn btn-info btn-sm" title="Preview">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kop-surat.edit', $kop) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if (!$kop->is_active)
                                                        <form action="{{ route('kop-surat.activate', $kop) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                title="Aktifkan"
                                                                onclick="return confirm('Aktifkan kop surat ini?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('kop-surat.destroy', $kop) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data kop surat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $kopSurat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
