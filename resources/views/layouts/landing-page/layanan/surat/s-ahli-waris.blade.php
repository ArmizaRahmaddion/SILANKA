@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>FORMULIR PENGAJUAN SURAT KETERANGAN AHLI WARIS/h1>
                            <p class="mb-0">Silahkan Isi Data Berikut Untuk Pembuatan Surat Keterangan Ahli Waris</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="form-sktm" class="py-5">
        <div class="container">
            <form action="#" method="POST">
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
                        <label>Nama Almarhum <span class="text-danger">*</span></label>
                        <input type="text" name="nama_almarhum" class="form-control" required
                            value="{{ old('nama_almarhum') }}">
                    </div>
                    <div class="col-md-6">
                        <label>NIK Almarhum <span class="text-danger">*</span></label>
                        <input type="text" name="nik_almarhum" class="form-control" required
                            value="{{ old('anak.nik') }}" placeholder="Masukkan 16 digit Nomor Induk Kependudukan">
                    </div>
                    <div class="col-md-6">
                        <label>Tempat Lahir Almarhum <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir_almarhum" class="form-control" required
                            value="{{ old('tempat_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Lahir Almarhum <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir_almarhum" class="form-control" required
                            value="{{ old('tanggal_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin_almarhum" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin_almarhum') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin_almarhum') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="agama_almarhum" class="form-label">agama_almarhum</label>
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
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat_almarhum" class="form-control" rows="2" required value="{{ old('alamat_almarhum') }}"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Hari Meninggal <span class="text-danger">*</span></label>
                        <textarea name="hari_meninggal" class="form-control" rows="2" required value="{{ old('hari_meninggal') }}"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal Meninggal Almarhum <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_meninggal_almarhum" class="form-control" required
                            value="{{ old('tanggal_meninggal_almarhum') }}">
                    </div>
                </div>

                <hr>



                <hr>

                <h5 class="mt-4">Ahli Waris</h5>
                <div id="ahliWaris-wrapper">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label>Nama</label>
                            <input type="text" name="ahli_waris[0][nama]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Jenis Kelamin</label>
                            <select name="ahli_waris[0][jenis_kelamin]" class="form-control" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Umur</label>
                            <input type="number" name="ahli_waris[0][umur]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Hubungan Dalam Keluarga</label>
                            <select name="ahli_waris[0][hubungan]" class="form-control" required>
                                <option value="" disabled selected>Pilih</option>
                                <option value="istri">istri</option>
                                <option value="anak">anak</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-row">X</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="jenis_surat_id" value="{{ $jenisSuratId }}">
                <input type="hidden" name="verifikasi_pengguna_id" value="{{ $verifikasi->id }}">

                <button type="button" class="btn btn-sm btn-primary my-2" id="add-ahliWaris">+ Tambah
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

        document.getElementById('add-ahliWaris').addEventListener('click', function() {
            const html = `
        <div class="row mb-2">
            <div class="col-md-3">
                <label>Nama</label>
                <input type="text" name="ahli_waris[${tjIndex}][nama]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Jenis Kelamin</label>
                <select name="ahli_waris[${tjIndex}][jenis_kelamin]" class="form-control" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>Umur</label>
                <input type="number" name="ahli_waris[${tjIndex}][umur]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Hubungan Dalam Keluarga</label>
                <select name="ahli_waris[${tjIndex}][hubungan]" class="form-control" required>
                    <option value="" disabled selected>Pilih</option>
                    <option value="istri">istri</option>
                    <option value="anak">anak</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-row">X</button>
            </div>
        </div>`;

            document.getElementById('ahliWaris-wrapper').insertAdjacentHTML('beforeend', html);
            tjIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.row').remove();
            }
        });
    </script>
@endpush
