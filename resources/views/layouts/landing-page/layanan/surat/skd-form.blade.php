@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Formulir Pengajuan Surat Keterangan Domisili</h1>
                        <p class="mb-0">Silakan isi data berikut untuk pembuatan surat keterangan domisili</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section id="form-sktm" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <form action="{{ route('skd.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <h4 class="mb-4 fw-semibold text-primary"><i class="bi bi-person-lines-fill"></i> Data
                                    Pemohon</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="keperluan" class="form-label">Keperluan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="keperluan" id="keperluan" class="form-control" required
                                            value="{{ old('keperluan') }}" placeholder="Contoh: Keperluan administrasi">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan"
                                            class="form-control bg-light" value="{{ date('Y-m-d') }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" required
                                            value="{{ old('nama') }}" placeholder="Nama lengkap sesuai KTP">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nik" class="form-label">Nomor Induk Kependudukan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nik" id="nik" maxlength="16"
                                            class="form-control" required value="{{ old('nik') }}"
                                            placeholder="16 digit NIK">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                            required value="{{ old('tempat_lahir') }}"
                                            placeholder="Tempat lahir sesuai KTP">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                            required value="{{ old('tanggal_lahir') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status_perkawinan" class="form-label">Status Perkawinan <span
                                                class="text-danger">*</span></label>
                                        <select name="status_perkawinan" id="status_perkawinan" class="form-select"
                                            required>
                                            <option value="">Pilih status</option>
                                            <option value="Belum Kawin"
                                                {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum
                                                Kawin</option>
                                            <option value="Kawin"
                                                {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup"
                                                {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                                                Hidup</option>
                                            <option value="Cerai Mati"
                                                {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                                class="text-danger">*</span></label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="Laki-Laki"
                                                {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="perempuan"
                                                {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agama" class="form-label">Agama <span
                                                class="text-danger">*</span></label>
                                        <select name="agama" id="agama" class="form-select" required>
                                            <option value="">Pilih agama</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam
                                            </option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>
                                                Kristen</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pekerjaan" class="form-label">Pekerjaan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                                            required value="{{ old('pekerjaan') }}"
                                            placeholder="Contoh: Karyawan Swasta">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alamat" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <select name="alamat" id="alamat" class="form-select" required>
                                            <option value="">Pilih alamat</option>
                                            <option value="Simpang tiga"
                                                {{ old('alamat') == 'Simpang tiga' ? 'selected' : '' }}>Simpang Tiga
                                            </option>
                                            <option value="Koto Ronah"
                                                {{ old('alamat') == 'Koto Ronah' ? 'selected' : '' }}>Koto Ronah</option>
                                            <option value="Koto Tangah"
                                                {{ old('alamat') == 'Koto Tangah' ? 'selected' : '' }}>Koto Tangah</option>
                                            <option value="Polong Duo"
                                                {{ old('alamat') == 'Polong Duo' ? 'selected' : '' }}>Polong Duo</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm"><i
                                            class="bi bi-send"></i> Kirim Pengajuan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
