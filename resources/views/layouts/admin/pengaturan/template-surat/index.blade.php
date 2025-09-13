@extends('layouts.dashboard-layouts')

@section('title', 'Template Surat')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Template Surat</h3>
                        <div class="card-tools">
                            <a href="{{ route('template-surat.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Template
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Nama Template</th>
                                        <th width="15%">Kategori</th>
                                        <th width="25%">Judul Surat</th>
                                        <th width="15%">Variables</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $index => $template)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $template->nama_template }}</strong>
                                                @if ($template->keterangan)
                                                    <br><small
                                                        class="text-muted">{{ Str::limit($template->keterangan, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $template->kategori }}</span>
                                            </td>
                                            <td>{{ $template->judul_surat }}</td>
                                            <td>
                                                @if ($template->variables && count($template->variables) > 0)
                                                    @foreach (array_slice($template->variables, 0, 3) as $variable)
                                                        <span class="badge badge-secondary">{!! $variable !!}</span>
                                                    @endforeach
                                                    @if (count($template->variables) > 3)
                                                        <span
                                                            class="badge badge-light">+{{ count($template->variables) - 3 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($template->is_active)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                                        data-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('template-surat.show', $template) }}">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('template-surat.preview', $template) }}"
                                                            target="_blank">
                                                            <i class="fas fa-search"></i> Preview
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('template-surat.generate', $template) }}">
                                                            <i class="fas fa-file-alt"></i> Generate Surat
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item"
                                                            href="{{ route('template-surat.edit', $template) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form
                                                            action="{{ route('template-surat.toggle-status', $template) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item">
                                                                <i
                                                                    class="fas fa-toggle-{{ $template->is_active ? 'off' : 'on' }}"></i>
                                                                {{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                            </button>
                                                        </form>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('template-surat.destroy', $template) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Yakin ingin menghapus template ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Belum ada template surat</h5>
                                                    <p class="text-muted">Silakan tambah template surat terlebih dahulu</p>
                                                    <a href="{{ route('template-surat.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Tambah Template
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
@endsection
