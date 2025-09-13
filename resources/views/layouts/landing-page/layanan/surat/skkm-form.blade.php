@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Formulir Pengajuan Surat Keterangan Meninggal Dunia</h1>
                        <p class="mb-0">Silakan isi data berikut untuk pembuatan surat keterangan meninggal dunia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section id="form-sktm" class="py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('skkm.store') }}" method="POST">
                @csrf

                <!-- Informasi Umum -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <input type="text" name="keperluan" id="keperluan" class="form-control" required
                            value="{{ old('keperluan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                            value="{{ date('Y-m-d') }}" disabled>
                    </div>
                </div>

                <!-- Data Almarhum -->
                <h4 class="mb-3 mt-4">Data Almarhum</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_almarhum" class="form-label">Nama Almarhum</label>
                        <input type="text" name="nama_almarhum" id="nama_almarhum" class="form-control" required
                            value="{{ old('nama_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik_almarhum" class="form-label">NIK Almarhum</label>
                        <input type="text" name="nik_almarhum" id="nik_almarhum" maxlength="16" class="form-control"
                            required value="{{ old('nik_almarhum') }}"
                            placeholder="Masukkan 16 digit Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir_almarhum" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_almarhum" id="tempat_lahir_almarhum" class="form-control"
                            required value="{{ old('tempat_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir_almarhum" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_almarhum" id="tanggal_lahir_almarhum" class="form-control"
                            required value="{{ old('tanggal_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin_almarhum" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin_almarhum" id="jenis_kelamin_almarhum" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin_almarhum') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin_almarhum') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="agama_almarhum" class="form-label">Agama Almarhum</label>
                        <select name="agama_almarhum" id="agama_almarhum" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Islam" {{ old('agama_almarhum') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama_almarhum') == 'Kristen' ? 'selected' : '' }}>Kristen
                            </option>
                            <option value="Hindu" {{ old('agama_almarhum') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ old('agama_almarhum') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat_almarhum" class="form-label">Alamat Almarhum</label>
                        <select name="alamat_almarhum" id="alamat_almarhum" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Simpang tiga" {{ old('alamat_almarhum') == 'Simpang tiga' ? 'selected' : '' }}>
                                Simpang Tiga</option>
                            <option value="Koto Ronah" {{ old('alamat_almarhum') == 'Koto Ronah' ? 'selected' : '' }}>Koto
                                Ronah</option>
                            <option value="Koto Tangah" {{ old('alamat_almarhum') == 'Koto Tangah' ? 'selected' : '' }}>
                                Koto Tangah</option>
                            <option value="Polong Duo" {{ old('alamat_almarhum') == 'Polong Duo' ? 'selected' : '' }}>
                                Polong Duo</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="tanggal_meninggal" class="form-label">Tanggal Meninggal</label>
                        <input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control"
                            required value="{{ old('tanggal_meninggal') }}">
                    </div>
                </div>

                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">


                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
