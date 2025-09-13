@extends('layouts.landing-page.layout')

@section('content')
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="mb-3">Layanan Pengaduan</h1>
                        <p class="mb-0">
                            Sampaikan pengaduan Anda dengan jelas dan lengkap agar dapat segera ditindaklanjuti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="#">Beranda</a></li>
                    <li class="current">E-Aduan</li>
                </ol>
            </div>
        </nav>
    </div>

    <section id="layanan-pengaduan" class="py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Periksa kembali isian Anda:</strong>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-4">Form Pengaduan</h5>

                            <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data"
                                novalidate>
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="kategori_pengaduan_id" class="form-label fw-medium">Kategori <span
                                                class="text-danger">*</span></label>
                                        <select id="kategori_pengaduan_id" name="kategori_pengaduan_id"
                                            class="form-select @error('kategori_pengaduan_id') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" @selected(old('kategori_pengaduan_id') == $kategori->id)>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_pengaduan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label fw-medium">Tanggal</label>
                                        <input type="text" id="tanggal" class="form-control"
                                            value="{{ date('d/m/Y') }}" disabled>
                                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="pengaduan" class="form-label fw-medium">Isi Pengaduan <span
                                                class="text-danger">*</span></label>
                                        <textarea id="pengaduan" name="pengaduan" class="form-control @error('pengaduan') is-invalid @enderror" rows="5"
                                            placeholder="Tuliskan secara jelas kronologi, lokasi, waktu kejadian, serta pihak terkait." required>{{ old('pengaduan') }}</textarea>
                                        <div class="form-text">Hindari mencantumkan data pribadi sensitif yang tidak
                                            relevan.</div>
                                        @error('pengaduan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="file" class="form-label fw-medium">File Pendukung (Opsional)</label>
                                        <input type="file" id="file" name="file"
                                            class="form-control @error('file') is-invalid @enderror"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <div class="form-text">
                                            Format: JPG, PNG, PDF, DOC (maks 2MB).
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Kirim Pengaduan
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-semibold mb-3">Data Pelapor</h6>
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Nama</label>
                                <input type="text" class="form-control" value="{{ $verifikasi->nama_lengkap }}"
                                    disabled>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small text-muted mb-1">Kontak (Nomor HP)</label>
                                <input type="text" class="form-control" value="{{ $verifikasi->nomor_hp }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h6 class="fw-semibold mb-3">Tips Pengisian</h6>
                            <ul class="small ps-3 mb-0">
                                <li>Gunakan bahasa yang sopan dan jelas.</li>
                                <li>Pastikan informasi faktual dan dapat dipertanggungjawabkan.</li>
                                <li>Lampirkan bukti jika tersedia.</li>
                                <li>Satu pengaduan untuk satu topik.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
