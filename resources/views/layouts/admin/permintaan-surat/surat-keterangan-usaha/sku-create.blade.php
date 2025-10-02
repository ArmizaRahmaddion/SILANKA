@extends('layouts.dashboard-layouts')
@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title mb-0">Buat Surat Keterangan Usaha</h4>
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

                                <div class="col-md-6">
                                    <label class="form-label">Nama</label>
                                    {!! readonlyInput('nama', $suratData->nama ?? '-') !!}
                                    <input type="hidden" name="nama" value="{{ $suratData->nama ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Induk Kependudukan</label>
                                    {!! readonlyInput('nik', $suratData->nik ?? '-') !!}
                                    <input type="hidden" name="nik" value="{{ $suratData->nik ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    {!! readonlyInput('tempat_lahir', $suratData->tempat_lahir ?? '-') !!}
                                    <input type="hidden" name="tempat_lahir" value="{{ $suratData->tempat_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    {!! readonlyInput(
                                        'tanggal_lahir',
                                        $suratData->tanggal_lahir ? \Carbon\Carbon::parse($suratData->tanggal_lahir)->format('d M Y') : '-',
                                    ) !!}
                                    <input type="hidden" name="tanggal_lahir"
                                        value="{{ $suratData->tanggal_lahir ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Perkawinan</label>
                                    {!! readonlyInput('status_perkawinan', $suratData->status_perkawinan ?? '-') !!}
                                    <input type="hidden" name="status_perkawinan"
                                        value="{{ $suratData->status_perkawinan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    {!! readonlyInput('jenis_kelamin', $suratData->jenis_kelamin ?? '-') !!}
                                    <input type="hidden" name="jenis_kelamin"
                                        value="{{ $suratData->jenis_kelamin ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Agama</label>
                                    {!! readonlyInput('agama', $suratData->agama ?? '-') !!}
                                    <input type="hidden" name="agama" value="{{ $suratData->agama ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan</label>
                                    {!! readonlyInput('pekerjaan', $suratData->pekerjaan ?? '-') !!}
                                    <input type="hidden" name="pekerjaan" value="{{ $suratData->pekerjaan ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    {!! readonlyInput('alamat', $suratData->alamat ? str_replace('_', ' ', ucwords($suratData->alamat, '_')) : '-') !!}
                                    <input type="hidden" name="alamat" value="{{ $suratData->alamat ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Usaha</label>
                                    {!! readonlyInput(
                                        'jenis_usaha',
                                        $suratData->jenis_usaha ? str_replace('_', ' ', ucwords($suratData->jenis_usaha, '_')) : '-',
                                    ) !!}
                                    <input type="hidden" name="jenis_usaha" value="{{ $suratData->jenis_usaha ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Luas Usaha</label>
                                    {!! readonlyInput(
                                        'luas_usaha',
                                        $suratData->luas_usaha ? str_replace('_', ' ', ucwords($suratData->luas_usaha, '_')) : '-',
                                    ) !!}
                                    <input type="hidden" name="luas_usaha" value="{{ $suratData->luas_usaha ?? '' }}">
                                </div>
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
