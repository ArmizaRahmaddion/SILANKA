@extends('layouts.dashboard-layouts')

@section('title', 'Detail Kop Surat')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Kop Surat</h3>
                        <div class="card-tools">
                            <a href="{{ route('kop-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('kop-surat.edit', $kopSurat) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('kop-surat.word-preview', $kopSurat) }}" class="btn btn-primary"
                                target="_blank">
                                <i class="fas fa-file-word"></i> Preview Word
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Informasi Kop Surat -->
                            <div class="col-md-8">
                                <h5 class="mb-3">Informasi Instansi</h5>

                                <table class="table table-borderless">
                                    <tr>
                                        <td width="200"><strong>Nama Instansi (Baris 1)</strong></td>
                                        <td>: {{ $kopSurat->nama_instansi }}</td>
                                    </tr>
                                    @if ($kopSurat->nama_instansi_2)
                                        <tr>
                                            <td><strong>Nama Instansi (Baris 2)</strong></td>
                                            <td>: {{ $kopSurat->nama_instansi_2 }}</td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->nama_instansi_3)
                                        <tr>
                                            <td><strong>Nama Instansi (Baris 3)</strong></td>
                                            <td>: {{ $kopSurat->nama_instansi_3 }}</td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->alamat)
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>: {{ $kopSurat->alamat }}</td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->telepon)
                                        <tr>
                                            <td><strong>Telepon</strong></td>
                                            <td>: {{ $kopSurat->telepon }}</td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->email)
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>: {{ $kopSurat->email }}</td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->website)
                                        <tr>
                                            <td><strong>Website</strong></td>
                                            <td>: <a href="{{ $kopSurat->website }}"
                                                    target="_blank">{{ $kopSurat->website }}</a></td>
                                        </tr>
                                    @endif
                                    @if ($kopSurat->kode_pos)
                                        <tr>
                                            <td><strong>Kode Pos</strong></td>
                                            <td>: {{ $kopSurat->kode_pos }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>:
                                            @if ($kopSurat->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat</strong></td>
                                        <td>: {{ $kopSurat->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui</strong></td>
                                        <td>: {{ $kopSurat->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Logo -->
                            <div class="col-md-4">
                                <h5 class="mb-3">Logo Instansi</h5>
                                @if ($kopSurat->logo)
                                    <div class="text-center">
                                        <img src="{{ Storage::url($kopSurat->logo) }}"
                                            alt="Logo {{ $kopSurat->nama_instansi }}" class="img-fluid border rounded"
                                            style="max-width: 200px; max-height: 200px;">
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="border rounded p-4"
                                            style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                            <span class="text-muted">
                                                <i class="fas fa-image fa-3x"></i><br>
                                                Tidak ada logo
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Preview Kop Surat -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Preview Kop Surat</h5>
                                <div class="border rounded p-4" style="background-color: #fff;">
                                    <div class="d-flex align-items-center mb-3"
                                        style="border-bottom: 3px solid #000; padding-bottom: 15px;">
                                        @if ($kopSurat->logo)
                                            <div style="width: 80px; height: 80px; margin-right: 20px; flex-shrink: 0;">
                                                <img src="{{ Storage::url($kopSurat->logo) }}" alt="Logo"
                                                    style="width: 100%; height: 100%; object-fit: contain;">
                                            </div>
                                        @endif

                                        <div class="text-center flex-grow-1">
                                            <div
                                                style="font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px;">
                                                {{ $kopSurat->nama_instansi }}
                                            </div>

                                            @if ($kopSurat->nama_instansi_2)
                                                <div
                                                    style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px;">
                                                    {{ $kopSurat->nama_instansi_2 }}
                                                </div>
                                            @endif

                                            @if ($kopSurat->nama_instansi_3)
                                                <div
                                                    style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">
                                                    {{ $kopSurat->nama_instansi_3 }}
                                                </div>
                                            @endif

                                            <div style="font-size: 12px; line-height: 1.3;">
                                                @php
                                                    $kontak = [];
                                                    if ($kopSurat->alamat) {
                                                        $kontak[] = 'Alamat : ' . $kopSurat->alamat;
                                                    }
                                                    if ($kopSurat->email) {
                                                        $kontak[] = 'Email : ' . $kopSurat->email;
                                                    }
                                                    if ($kopSurat->kode_pos) {
                                                        $kontak[] = 'Kode Pos : ' . $kopSurat->kode_pos;
                                                    }
                                                    if ($kopSurat->telepon) {
                                                        $kontak[] = 'Telp : ' . $kopSurat->telepon;
                                                    }
                                                    if ($kopSurat->website) {
                                                        $kontak[] = 'Website : ' . $kopSurat->website;
                                                    }
                                                @endphp

                                                @if (!empty($kontak))
                                                    {{ implode(' ', $kontak) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($kopSurat->header_content || $kopSurat->footer_content)
                            <hr>

                            <!-- Konten Tambahan -->
                            <div class="row">
                                @if ($kopSurat->header_content)
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Header Content</h5>
                                        <div class="border rounded p-3" style="background-color: #f8f9fa;">
                                            {!! $kopSurat->header_content !!}
                                        </div>
                                    </div>
                                @endif

                                @if ($kopSurat->footer_content)
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Footer Content</h5>
                                        <div class="border rounded p-3" style="background-color: #f8f9fa;">
                                            {!! $kopSurat->footer_content !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('kop-surat.edit', $kopSurat) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Kop Surat
                                </a>

                                @if (!$kopSurat->is_active)
                                    <form action="{{ route('kop-surat.activate', $kopSurat) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Aktifkan kop surat ini?')">
                                            <i class="fas fa-check"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="col-md-6 text-right">
                                <a href="{{ route('kop-surat.word-preview', $kopSurat) }}" class="btn btn-primary"
                                    target="_blank">
                                    <i class="fas fa-file-word"></i> Preview Word
                                </a>

                                <form action="{{ route('kop-surat.destroy', $kopSurat) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus kop surat ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
