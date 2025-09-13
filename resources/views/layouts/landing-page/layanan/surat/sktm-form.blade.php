@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>FORMULIR PENGAJUAN SURAT SKTM</h1>
                        <p class="mb-0">Silahkan Isi Data Berikut Untuk Pembuatan Surat Keterangan Tidak Mampu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="form-sktm" class="py-5">
        <div class="container">
            <form action="{{ route('sktm.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" id="keperluan" class="form-control" required
                            value="{{ old('keperluan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                            value="{{ date('Y-m-d') }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="anak[nama]" class="form-control" required
                            value="{{ old('anak.nama') }}">
                    </div>
                    <div class="col-md-6">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="anak[nik]" class="form-control" required value="{{ old('anak.nik') }}"
                            placeholder="Masukkan 16 digit Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-6">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="anak[tempat_lahir]" class="form-control" required
                            value="{{ old('anak.tempat_lahir') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="anak[tanggal_lahir]" class="form-control" required
                            value="{{ old('anak.tanggal_lahir') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="anak[jenis_kelamin]" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('anak.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('anak.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="anak[pekerjaan]" class="form-control" required
                            value="{{ old('anak.pekerjaan') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="anak[status_perkawinan]" class="form-control" required>
                            <option value="">Pilih</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('anak.status_perkawinan') == $status ? 'selected' : '' }}>{{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="anak[alamat]" class="form-control" rows="2" required value="{{ old('anak.alamat') }}"></textarea>
                    </div>
                </div>

                <hr>

                <h5 class="mt-4">Data Orang Tua</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="ortu[nama]" class="form-control" required
                            value="{{ old('ortu.nama') }}">
                    </div>
                    <div class="col-md-6">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="ortu[nik]" class="form-control" required value="{{ old('ortu.nik') }}"
                            placeholder="Masukkan 16 digit Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-6">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="ortu[tempat_lahir]" class="form-control" required
                            value="{{ old('ortu.tempat_lahir') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="ortu[tanggal_lahir]" class="form-control" required
                            value="{{ old('ortu.tanggal_lahir') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="ortu[jenis_kelamin]" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('ortu.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('ortu.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="ortu[pekerjaan]" class="form-control" required
                            value="{{ old('ortu.pekerjaan') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="ortu[status_perkawinan]" class="form-control" required>
                            <option value="">Pilih</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('ortu.status_perkawinan') == $status ? 'selected' : '' }}>{{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="ortu[alamat]" class="form-control" rows="2" required value="{{ old('ortu.alamat') }}"></textarea>
                    </div>
                </div>

                <hr>

                <h5 class="mt-4">Tanggung Jawab Keluarga</h5>
                <div id="tanggungjawab-wrapper">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label>Nama</label>
                            <input type="text" name="tanggung_jawab[0][nama]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label>Umur</label>
                            <input type="number" name="tanggung_jawab[0][umur]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Pekerjaan</label>
                            <input type="text" name="tanggung_jawab[0][pekerjaan]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Keterangan</label>
                            <input type="text" name="tanggung_jawab[0][keterangan]" class="form-control" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-row">X</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">

                <button type="button" class="btn btn-sm btn-primary my-2" id="add-tanggungjawab">+ Tambah
                    Anggota</button>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line"></i> Simpan Surat
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let tjIndex = 1;
        document.getElementById('add-tanggungjawab').addEventListener('click', function() {
            const html = `
            <div class="row mb-2">
                <div class="col-md-3">
                    <label>Nama</label>
                    <input type="text" name="tanggung_jawab[${tjIndex}][nama]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label>Umur</label>
                    <input type="number" name="tanggung_jawab[${tjIndex}][umur]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="tanggung_jawab[${tjIndex}][pekerjaan]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Keterangan</label>
                    <input type="text" name="tanggung_jawab[${tjIndex}][keterangan]" class="form-control" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-row">X</button>
                </div>
            </div>`;
            document.getElementById('tanggungjawab-wrapper').insertAdjacentHTML('beforeend', html);
            tjIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.row').remove();
            }
        });
    </script>
@endpush
