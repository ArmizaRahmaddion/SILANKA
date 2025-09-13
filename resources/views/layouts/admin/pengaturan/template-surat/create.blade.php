@extends('layouts.dashboard-layouts')

@section('title', 'Tambah Template Surat')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Template Surat</h3>
                        <div class="card-tools">
                            <a href="{{ route('template-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('template-surat.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_template">Nama Template <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nama_template') is-invalid @enderror"
                                            id="nama_template" name="nama_template" value="{{ old('nama_template') }}"
                                            placeholder="Contoh: Template SKTM Standar">
                                        @error('nama_template')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoris as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('kategori') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="judul_surat">Judul Surat <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('judul_surat') is-invalid @enderror" id="judul_surat"
                                            name="judul_surat" value="{{ old('judul_surat') }}"
                                            placeholder="Contoh: SURAT KETERANGAN TIDAK MAMPU">
                                        @error('judul_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Bisa menggunakan variable seperti:
                                            {jenis_surat}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor_format">Format Nomor Surat</label>
                                        <input type="text"
                                            class="form-control @error('nomor_format') is-invalid @enderror"
                                            id="nomor_format" name="nomor_format" value="{{ old('nomor_format') }}"
                                            placeholder="Contoh: {nomor_urut}/SKTM/{bulan_romawi}/{tahun}">
                                        @error('nomor_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Gunakan variable untuk nomor dinamis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="isi_surat">Isi Surat <span class="text-danger">*</span></label>
                                <x-forms.tinymce-editor name="isi_surat" id="isi_surat" value="{{ old('isi_surat') }}"
                                    height="400" />
                                @error('isi_surat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3" placeholder="Keterangan tambahan tentang template ini">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Panduan Variables -->
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Panduan Penggunaan Variables</h6>
                                <p class="mb-2">Gunakan format <code>{nama_variable}</code> untuk membuat placeholder yang
                                    bisa diganti saat generate surat:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Data Pribadi:</strong>
                                        <ul class="mb-0">
                                            <li><code>{nama}</code> - Nama lengkap</li>
                                            <li><code>{nik}</code> - NIK</li>
                                            <li><code>{alamat}</code> - Alamat lengkap</li>
                                            <li><code>{tempat_lahir}</code> - Tempat lahir</li>
                                            <li><code>{tanggal_lahir}</code> - Tanggal lahir</li>
                                            <li><code>{jenis_kelamin}</code> - Jenis kelamin</li>
                                            <li><code>{agama}</code> - Agama</li>
                                            <li><code>{pekerjaan}</code> - Pekerjaan</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Data Surat:</strong>
                                        <ul class="mb-0">
                                            <li><code>{tanggal_surat}</code> - Tanggal surat</li>
                                            <li><code>{nomor_urut}</code> - Nomor urut</li>
                                            <li><code>{tahun}</code> - Tahun</li>
                                            <li><code>{bulan_romawi}</code> - Bulan romawi</li>
                                            <li><code>{keperluan}</code> - Keperluan surat</li>
                                            <li><code>{keterangan_tambahan}</code> - Keterangan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Template
                            </button>
                            <a href="{{ route('template-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
