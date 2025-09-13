@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>FORMULIR PENGAJUAN SURAT KETERANGAN AHLI WARIS</h1>
                        <p class="mb-0">Silahkan Isi Data Berikut Untuk Pembuatan Surat Keterangan Ahli Waris</p>
                    </div>
                </div>
            </div>
        </div>    </div>

    <section id="form-skaw" class="py-5">
        <div class="container">

            <form action="#" method="POST">
                @csrf

                <div class="col-md-6 mb-3">
                    <label>Keperluan</label>
                    <input type="text" name="keperluan" class="form-control" required value="{{ old('keperluan') }}">
                </div>
                <h4 class="mb-3">Data almarhum</h4>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama Almarhum</label>
                        <input type="text" name="nama_almarhum" class="form-control" required
                            value="{{ old('nama_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK Almarhum</label>
                        <input type="text" name="nik_almarhum" maxlength="16" class="form-control" required
                            value="{{ old('nik_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_almarhum" class="form-control" required
                            value="{{ old('tempat_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_almarhum" class="form-control" required
                            value="{{ old('tanggal_lahir_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_almarhum" class="form-control" required
                            value="{{ old('jenis_kelamin_almarhum') }}">
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Agama Almarhum</label>
                        <input type="text" name="agama_almarhum" class="form-control" required
                            value="{{ old('agama_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Perkawinan Almarhum</label>
                        <input type="text" name="status_perkawinan_almarhum" class="form-control" required
                            value="{{ old('status_perkawinan_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Pengajuan Surat</label>
                        <input type="date" name="tanggal_pengajuan" class="form-control" required
                            value="{{ date('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label>Alamat Almarhum</label>
                        <textarea name="alamat_almarhum" class="form-control" rows="2" required value="{{ old('alamat_almarhum') }}"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Hari Meninggal Almarhum</label>
                        <input type="text" name="hari_meninggal_almarhum" class="form-control" required
                            value="{{ old('hari_meninggal_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Meninggal Almarhum</label>
                        <input type="date" name="tanggal_meninggal_almarhum" class="form-control" required
                            value="{{ old('tanggal_meninggal_almarhum') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tempat Pemakaman Almarhum</label>
                        <input type="text" name="tempat_pemakaman_almarhum" class="form-control" required
                            value="{{ old('tempat_pemakaman_almarhum') }}">
                    </div>
                </div>


                <h4 class="mb-3">Data Ahli Waris (Anak/Anggota Keluarga)</h4>
                <div id="ahliwaris-container">
                    <div class="row ahliwaris-row">
                        <div class="col-md-4 mb-3">
                            <label>Nama</label>
                            <input type="text" name="ahliwaris[0][nama]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="ahliwaris[0][jenis_kelamin]" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Umur</label>
                            <input type="number" name="ahliwaris[0][umur]" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Hubungan Dalam Keluarga</label>
                            <input type="text" name="ahliwaris[0][keterangan]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="button" id="addAhliwairs" class="btn btn-sm btn-outline-primary">Tambah
                        Data Ahli Waris</button>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Upload Foto KTP Almarhum</label>
                    <input type="file" name="foto_ktp" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Upload Foto Kartu Keluarga</label>
                    <input type="file" name="kartu_keluarga" class="form-control" required>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </form>


        </div>
    </section>

    </main>
@endsection

@push('scripts')
    <script>
        let tanggunganIndex = 1;

        document.getElementById('addAhliwairs').addEventListener('click', function() {
            const container = document.getElementById('ahliwaris-container');

            const html = `
        <div class="row ahliwaris-row">
            <div class="col-md-4 mb-3">
                <input type="text" name="ahliwaris[${ahliwarisIndex}][nama]" class="form-control" placeholder="Nama" required>
            </div>
            <div class="col-md-2 mb-3">
                <input type="number" name="ahliwaris[${ahliwarisIndex}][jenis_kelamin]" class="form-control" placeholder="Jenis Kelamin" required>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="ahliwaris[${ahliwarisIndex}][umur]" class="form-control" placeholder="umur" required>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="ahliwaris[${ahliwarisIndex}][keterangan]" class="form-control" placeholder="Keterangan" required>
            </div>
        </div>`;

            container.insertAdjacentHTML('beforeend', html);
            ahliwarisIndex++;
        });
    </script>
@endpush
