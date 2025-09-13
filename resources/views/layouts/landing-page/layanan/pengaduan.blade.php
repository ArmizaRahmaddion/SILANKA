@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>LAYANAN PENGADUAN</h1>
                        <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint
                            voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores.
                            Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
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
    </div><!-- End Page Title -->

    <section id="layanan-pengaduan" class="py-5">
        <div class="container">

            {{-- {{ dd($kategoris) }} --}}

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori_pengaduan_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal Pengaduan</label>
                    <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="{{ $verifikasi->nama_lengkap }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Kontak (Nomor HP)</label>
                    <input type="text" class="form-control" value="{{ $verifikasi->nomor_hp }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Isi Pengaduan</label>
                    <textarea name="pengaduan" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label>File Pendukung (opsional)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <button class="btn btn-primary">Kirim Pengaduan</button>
            </form>
        </div>
    </section>

    </main>
@endsection
