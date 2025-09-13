@extends('layouts.dashboard-layouts')
@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title mb-0">Buat Surat Keterangan Meninggal Dunia</h4>
                        <a href="{{ route('permintaan.surat') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        {{-- Alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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

                            {{-- Data Almarhum --}}
                            <h5 class="mb-3 mt-4">Data Almarhum</h5>
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
                                    <label class="form-label">Nama Almarhum</label>
                                    {!! readonlyInput('nama_almarhum', $suratData->nama_almarhum ?? '-') !!}
                                    <input type="hidden" name="nama_almarhum"
                                        value="{{ $suratData->nama_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Almarhum</label>
                                    {!! readonlyInput('nik_almarhum', $suratData->nik_almarhum ?? '-') !!}
                                    <input type="hidden" name="nik_almarhum" value="{{ $suratData->nik_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    {!! readonlyInput('tempat_lahir_almarhum', $suratData->tempat_lahir_almarhum ?? '-') !!}
                                    <input type="hidden" name="tempat_lahir_almarhum"
                                        value="{{ $suratData->tempat_lahir_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    {!! readonlyInput(
                                        'tanggal_lahir_almarhum',
                                        $suratData->tanggal_lahir_almarhum
                                            ? \Carbon\Carbon::parse($suratData->tanggal_lahir_almarhum)->format('d M Y')
                                            : '-',
                                    ) !!}
                                    <input type="hidden" name="tanggal_lahir_almarhum"
                                        value="{{ $suratData->tanggal_lahir_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    {!! readonlyInput('jenis_kelamin_almarhum', $suratData->jenis_kelamin_almarhum ?? '-') !!}
                                    <input type="hidden" name="jenis_kelamin_almarhum"
                                        value="{{ $suratData->jenis_kelamin_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Agama</label>
                                    {!! readonlyInput('agama_almarhum', $suratData->agama_almarhum ?? '-') !!}
                                    <input type="hidden" name="agama_almarhum"
                                        value="{{ $suratData->agama_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    {!! readonlyInput(
                                        'alamat_almarhum',
                                        $suratData->alamat_almarhum ? str_replace('_', ' ', ucwords($suratData->alamat_almarhum, '_')) : '-',
                                    ) !!}
                                    <input type="hidden" name="alamat_almarhum"
                                        value="{{ $suratData->alamat_almarhum ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Meninggal</label>
                                    {!! readonlyInput(
                                        'tanggal_meninggal',
                                        $suratData->tanggal_meninggal ? \Carbon\Carbon::parse($suratData->tanggal_meninggal)->format('d M Y') : '-',
                                    ) !!}
                                    <input type="hidden" name="tanggal_meninggal"
                                        value="{{ $suratData->tanggal_meninggal ?? '' }}">
                                </div>
                            </div>

                            <hr>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('permintaan.surat') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Surat
                                </button>
                            </div>
                        </form>
                    </div> {{-- end card-body --}}
                </div> {{-- end card --}}
            </div>
        </div>
    </div>
@endsection
