@extends('layouts.dashboard-layouts')

@section('title', 'Tambah Kop Surat')

@section('head')
    <x-head.tinymce-config />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Kop Surat</h3>
                        <div class="card-tools">
                            <a href="{{ route('kop-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('kop-surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Informasi Instansi</h5>

                                    <div class="form-group mb-3">
                                        <label for="nama_instansi" class="form-label">Nama Instansi (Baris 1) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_instansi" id="nama_instansi"
                                            class="form-control @error('nama_instansi') is-invalid @enderror"
                                            value="{{ old('nama_instansi') }}"
                                            placeholder="Contoh: PEMERINTAH KABUPATEN LIMA PULUH KOTA" required>
                                        @error('nama_instansi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nama_instansi_2" class="form-label">Nama Instansi (Baris 2)</label>
                                        <input type="text" name="nama_instansi_2" id="nama_instansi_2"
                                            class="form-control @error('nama_instansi_2') is-invalid @enderror"
                                            value="{{ old('nama_instansi_2') }}"
                                            placeholder="Contoh: KECAMATAN PANGKALAN KOTO BARU">
                                        @error('nama_instansi_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nama_instansi_3" class="form-label">Nama Instansi (Baris 3)</label>
                                        <input type="text" name="nama_instansi_3" id="nama_instansi_3"
                                            class="form-control @error('nama_instansi_3') is-invalid @enderror"
                                            value="{{ old('nama_instansi_3') }}" placeholder="Contoh: NAGARI KOTO ALAM">
                                        @error('nama_instansi_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                                            placeholder="Contoh: Jorong Koto Tangah Kenagarian Koto Alam">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Kontak & Logo</h5>

                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="Contoh: kotoalam2005@gmail.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" name="telepon" id="telepon"
                                            class="form-control @error('telepon') is-invalid @enderror"
                                            value="{{ old('telepon') }}" placeholder="Contoh: (0752) 123456">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" name="kode_pos" id="kode_pos"
                                            class="form-control @error('kode_pos') is-invalid @enderror"
                                            value="{{ old('kode_pos') }}" placeholder="Contoh: 26272">
                                        @error('kode_pos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url" name="website" id="website"
                                            class="form-control @error('website') is-invalid @enderror"
                                            value="{{ old('website') }}" placeholder="https://example.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="logo" class="form-label">Logo Instansi</label>
                                        <input type="file" name="logo" id="logo"
                                            class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Ukuran
                                            optimal: 80x80px</small>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                            value="1" {{ old('is_active') ? 'checked' : '' }}>
                                        <label for="is_active" class="form-check-label">Aktifkan kop surat ini</label>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Konten Tambahan (Opsional)</h5>
                                    <p class="text-muted">Gunakan editor di bawah jika ingin menambahkan konten khusus pada
                                        header atau footer kop surat.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <x-forms.tinymce-editor name="header_content" label="Konten Header Tambahan"
                                        placeholder="Konten tambahan untuk header (opsional)..." :value="old('header_content')" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <x-forms.tinymce-editor name="footer_content" label="Konten Footer"
                                        placeholder="Konten untuk footer kop surat (opsional)..." :value="old('footer_content')" />
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('kop-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
