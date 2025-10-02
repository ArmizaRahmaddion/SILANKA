@extends('layouts.dashboard-layouts')
@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title mb-0">Buat Surat Keterangan Domisili</h4>
                        <a href="{{ route('permintaan.surat') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">



                        {{-- Informasi Permintaan --}}
                        <h5 class="mb-3">Informasi Permintaan</h5>
                        <div class="card mb-4 border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Permintaan:</strong>
                                            {{ $permintaan->tanggal_permintaan->format('d M Y') }}</p>
                                        <p><strong>Jenis Surat:</strong> {{ $permintaan->jenisSurat->nama_surat }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Nama Pemohon:</strong>
                                            {{ $permintaan->verifikasiPengguna->nama_lengkap }}</p>
                                        <p><strong>NIK Pemohon:</strong> {{ $permintaan->verifikasiPengguna->nik }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Surat --}}
                        <form action="{{ route('permintaan-surat.simpan-surat', $permintaan->id) }}" method="POST">
                            @csrf

                            {{-- Nomor Surat dan Keperluan --}}
                            <h5 class="mb-3">Detail Surat</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nomor_surat" class="form-label">Nomor Surat <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                                        id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $nomorSurat) }}"
                                        required>
                                    @error('nomor_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="keperluan_display" class="form-label">Keperluan</label>
                                    <input type="text" class="form-control" id="keperluan_display"
                                        value="{{ $suratData->keperluan ?? '-' }}" readonly>
                                    <input type="hidden" name="keperluan" value="{{ $suratData->keperluan ?? '' }}">
                                </div>
                            </div>

                            <hr>


                            <div class="row g-3">
                                @php
                                    function readonlyInput($id, $value)
                                    {
                                        return '<input type="text" class="form-control" id="' .
                                            $id .
                                            '_display" value="' .
                                            $value .
                                            '" readonly>';
                                    }
                                @endphp

                                <h5 class="mt-4 mb-3">Data Yang Bersangkutan</h5>
                                <div class="col-md-6">
                                    <label class="form-label">Nama</label>
                                    {!! readonlyInput('anak_nama', $suratData->anak_nama ?? '-') !!}
                                    <input type="hidden" name="anak_nama" value="{{ $suratData->anak_nama ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Induk Kependudukan</label>
                                    {!! readonlyInput('anak_nik', $suratData->anak_nik ?? '-') !!}
                                    <input type="hidden" name="anak_nik" value="{{ $suratData->anak_nik ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    {!! readonlyInput('anak_tempat_lahir', $suratData->anak_tempat_lahir ?? '-') !!}
                                    <input type="hidden" name="anak_tempat_lahir"
                                        value="{{ $suratData->anak_tempat_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    {!! readonlyInput(
                                        'anak_tanggal_lahir',
                                        $suratData->anak_tanggal_lahir ? \Carbon\Carbon::parse($suratData->anak_tanggal_lahir)->format('d M Y') : '-',
                                    ) !!}
                                    <input type="hidden" name="anak_tanggal_lahir"
                                        value="{{ $suratData->anak_tanggal_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Perkawinan</label>
                                    {!! readonlyInput('anak_status_perkawinan', $suratData->anak_status_perkawinan ?? '-') !!}
                                    <input type="hidden" name="anak_status_perkawinan"
                                        value="{{ $suratData->anak_status_perkawinan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    {!! readonlyInput('anak_jenis_kelamin', $suratData->anak_jenis_kelamin ?? '-') !!}
                                    <input type="hidden" name="anak_jenis_kelamin"
                                        value="{{ $suratData->anak_jenis_kelamin ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan</label>
                                    {!! readonlyInput('anak_pekerjaan', $suratData->anak_pekerjaan ?? '-') !!}
                                    <input type="hidden" name="anak_pekerjaan"
                                        value="{{ $suratData->anak_pekerjaan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    {!! readonlyInput(
                                        'anak_alamat',
                                        $suratData->anak_alamat ? str_replace('_', ' ', ucwords($suratData->anak_alamat, '_')) : '-',
                                    ) !!}
                                    <input type="hidden" name="anak_alamat" value="{{ $suratData->anak_alamat ?? '' }}">
                                </div>

                                {{-- Data Orang Tua --}}
                                <h5 class="mt-4 mb-3">Data Orang Tua</h5>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Orang Tua</label>
                                    {!! readonlyInput('ortu_nama', $suratData->ortu_nama ?? '-') !!}
                                    <input type="hidden" name="ortu_nama" value="{{ $suratData->ortu_nama ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Induk Kependudukan</label>
                                    {!! readonlyInput('ortu_nik', $suratData->ortu_nik ?? '-') !!}
                                    <input type="hidden" name="ortu_nik" value="{{ $suratData->ortu_nik ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    {!! readonlyInput('ortu_tempat_lahir', $suratData->ortu_tempat_lahir ?? '-') !!}
                                    <input type="hidden" name="ortu_tempat_lahir"
                                        value="{{ $suratData->ortu_tempat_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    {!! readonlyInput(
                                        'ortu_tanggal_lahir',
                                        $suratData->ortu_tanggal_lahir ? \Carbon\Carbon::parse($suratData->ortu_tanggal_lahir)->format('d M Y') : '-',
                                    ) !!}
                                    <input type="hidden" name="ortu_tanggal_lahir"
                                        value="{{ $suratData->ortu_tanggal_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Perkawinan</label>
                                    {!! readonlyInput('ortu_status_perkawinan', $suratData->ortu_status_perkawinan ?? '-') !!}
                                    <input type="hidden" name="ortu_status_perkawinan"
                                        value="{{ $suratData->ortu_status_perkawinan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    {!! readonlyInput('ortu_jenis_kelamin', $suratData->ortu_jenis_kelamin ?? '-') !!}
                                    <input type="hidden" name="ortu_jenis_kelamin"
                                        value="{{ $suratData->ortu_jenis_kelamin ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan</label>
                                    {!! readonlyInput('ortu_pekerjaan', $suratData->ortu_pekerjaan ?? '-') !!}
                                    <input type="hidden" name="ortu_pekerjaan"
                                        value="{{ $suratData->ortu_pekerjaan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    {!! readonlyInput(
                                        'ortu_alamat',
                                        $suratData->ortu_alamat ? str_replace('_', ' ', ucwords($suratData->ortu_alamat, '_')) : '-',
                                    ) !!}
                                    <input type="hidden" name="ortu_alamat"
                                        value="{{ $suratData->ortu_alamat ?? '' }}">
                                </div>

                                {{-- Data Tanggungan Keluarga --}}
                                <h5 class="mt-4 mb-3">Data Tanggungan Keluarga</h5>

                                @if (!empty($suratData->tanggungJawab) && count($suratData->tanggungJawab) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Umur</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($suratData->tanggungJawab as $index => $anggota)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <input type="text" class="form-control-plaintext"
                                                                value="{{ $anggota->nama }}" readonly>
                                                            <input type="hidden"
                                                                name="tanggungJawab[{{ $index }}][nama]"
                                                                value="{{ $anggota->nama }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control-plaintext"
                                                                value="{{ $anggota->umur }}" readonly>
                                                            <input type="hidden"
                                                                name="tanggungJawab[{{ $index }}][umur]"
                                                                value="{{ $anggota->umur }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control-plaintext"
                                                                value="{{ $anggota->pekerjaan }}" readonly>
                                                            <input type="hidden"
                                                                name="tanggungJawab[{{ $index }}][pekerjaan]"
                                                                value="{{ $anggota->pekerjaan }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control-plaintext"
                                                                value="{{ $anggota->keterangan }}" readonly>
                                                            <input type="hidden"
                                                                name="tanggungJawab[{{ $index }}][keterangan]"
                                                                value="{{ $anggota->keterangan }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted fst-italic">Tidak ada data tanggungan keluarga.</p>
                                @endif


                            </div>

                            <hr>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4 d-flex justify-content-end gap-2 align-items-center">
                                <a href="{{ route('permintaan.surat') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Surat
                                </button>
                                <!-- Tombol Tolak Surat -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#tolakSuratModal">Tolak Surat</button>
                            </div>
                        </form>

                        <!-- Modal Tolak Surat -->
                        <div class="modal fade" id="tolakSuratModal" tabindex="-1"
                            aria-labelledby="tolakSuratModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('permintaan-surat.tolak', $permintaan->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tolakSuratModalLabel">Tolak Permintaan Surat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="alasanTolak" class="form-label">Alasan Penolakan <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="alasan" id="alasanTolak" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> {{-- end card-body --}}
                </div> {{-- end card --}}
            </div>
        </div>
    </div>
@endsection
