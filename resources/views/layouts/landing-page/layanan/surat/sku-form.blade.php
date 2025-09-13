@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Formulir Pengajuan Surat Keterangan Usaha</h1>
                        <p class="mb-0">Silakan isi data berikut untuk pembuatan surat keterangan usaha</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section id="form-sktm" class="py-5">
        <div class="container">
            <form action="{{ Route('sku.store') }}" method="POST">
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
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required
                            value="{{ old('nama') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">Nomor Induk Kependudukan</label>
                        <input type="text" name="nik" id="nik" maxlength="16" class="form-control" required
                            value="{{ old('nik') }}" placeholder="Masukkan 16 digit Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                            value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                            value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>
                                Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin
                            </option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>
                                Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>
                                Cerai Mati</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>Pilih
                            </option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required
                            value="{{ old('pekerjaan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <select name="alamat" id="alamat" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Simpang tiga" {{ old('alamat') == 'Simpang tiga' ? 'selected' : '' }}>
                                Simpang Tiga</option>
                            <option value="Koto Ronah" {{ old('alamat') == 'Koto Ronah' ? 'selected' : '' }}>
                                Koto Ronah</option>
                            <option value="Koto Tangah" {{ old('alamat') == 'Koto Tangah' ? 'selected' : '' }}>
                                Koto Tangah</option>
                            <option value="Polong Duo" {{ old('alamat') == 'Polong Duo' ? 'selected' : '' }}>
                                Polong Duo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                        <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required
                            value="{{ old('jenis_usaha') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="luas_usaha" class="form-label">Luas Usaha</label>
                        <input type="text" name="luas_usaha" id="luas_usaha" class="form-control" required
                            value="{{ old('luas_usaha') }}">
                    </div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>

                <!-- Example SweetAlert Trigger (Optional - Shouldn't be here if not used properly) -->
                <script>
                    Swal.fire('Sukses', 'SweetAlert berhasil dipanggil', 'success');
                </script>
            </form>
        </div>
    </section>
@endsection
