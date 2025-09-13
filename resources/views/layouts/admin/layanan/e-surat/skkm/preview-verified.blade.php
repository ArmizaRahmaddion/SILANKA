@extends('layouts.dashboard-layouts')
@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Preview Surat Terverifikasi</h4>
                            <p class="text-muted mb-0">{{ $verifikasi->jenisSurat->nama_surat ?? 'Surat' }} -
                                {{ $verifikasi->suratTerbit->nomor_surat }}</p>
                        </div>
                        <div>
                            <a href="{{ route('verifikasi.verified') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Status Verifikasi -->
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="ri-shield-check-fill me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Surat Terverifikasi</strong><br>
                                <small>
                                    Diverifikasi pada: {{ $verifikasi->verified_at->format('d/m/Y H:i') }}
                                    oleh {{ $verifikasi->verifiedBy->name ?? 'System' }}
                                </small>
                            </div>
                        </div>

                        <!-- Preview Content -->
                        <div class="preview-container"
                            style="border: 1px solid #ddd; padding: 30px; background: white; border-radius: 10px;">
                            <!-- Header Surat -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/kokop.png') }}" alt="Kop Surat"
                                    style="max-width: 100%; height: auto; max-height: 150px;">
                            </div>

                            <!-- Title -->
                            <div class="text-center mb-4">
                                <h5 class="fw-bold text-decoration-underline">
                                    @if ($verifikasi->jenisSurat->kode_surat === 'SKKM')
                                        SURAT KETERANGAN MENINGGAL DUNIA
                                    @else
                                        {{ strtoupper($verifikasi->jenisSurat->nama_surat) }}
                                    @endif
                                </h5>
                                <p class="mb-0">Nomor : {{ $verifikasi->suratTerbit->nomor_surat }}</p>
                            </div>

                            @if ($verifikasi->jenisSurat->kode_surat === 'SKKM' && $skkm)
                                <!-- Content SKKM -->
                                <div class="content-section">
                                    <p>Yang bertanda tangan di bawah ini PJ. Wali Nagari Koto Alam Kecamatan Pangkalan Koto
                                        Baru Kabupaten Lima Puluh Kota menerangkan bahwa:</p>

                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Nama</strong></td>
                                                    <td width="10">:</td>
                                                    <td>{{ $skkm->nama_almarhum }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $skkm->nik_almarhum }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tempat/ Tgl Lahir</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $skkm->tempat_lahir_almarhum }},
                                                        {{ \Carbon\Carbon::parse($skkm->tanggal_lahir_almarhum)->translatedFormat('d F Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis Kelamin</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $skkm->jenis_kelamin_almarhum }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Agama</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $skkm->agama_almarhum }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Alamat</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $skkm->alamat_almarhum }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            @if ($verifikasi->barcode)
                                                <div class="text-center border p-3"
                                                    style="background: #f8f9fa; border-radius: 10px;">
                                                    <h6 class="fw-bold mb-3">BARCODE VERIFIKASI</h6>
                                                    <img src="{{ asset('storage/' . $verifikasi->barcode) }}"
                                                        alt="Barcode Verifikasi"
                                                        style="width: 150px; height: 150px; border: 1px solid #ddd;">
                                                    <div class="mt-2">
                                                        <small class="text-muted d-block">Scan untuk verifikasi</small>
                                                        <small class="text-success fw-bold">✓ Terverifikasi</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <p>Berdasarkan pernyataan dari pihak keluarga, bahwa nama yang tersebut di atas benar
                                        penduduk Jorong {{ $skkm->alamat_almarhum }} Nagari Koto Alam yang telah
                                        meninggal dunia pada tanggal
                                        {{ \Carbon\Carbon::parse($skkm->tanggal_meninggal)->translatedFormat('d F Y') }},
                                        di Nagari Koto Alam.</p>

                                    <p>Demikianlah Surat Keterangan Meninggal Dunia ini kami berikan untuk dapat digunakan
                                        seperlunya.</p>
                                </div>
                            @endif

                            <!-- Signature Section -->
                            <div class="row mt-5">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-start">
                                    <p>Dikeluarkan di : Koto Alam<br>
                                        Pada Tanggal :
                                        {{ \Carbon\Carbon::parse($verifikasi->suratTerbit->tanggal_terbit ?? now())->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="mt-4">PJ. Wali Nagari Koto Alam</p>

                                    @if ($verifikasi->barcode)
                                        <div class="text-center my-4">
                                            <img src="{{ asset('storage/' . $verifikasi->barcode) }}" alt="Barcode"
                                                style="width: 80px; height: 80px;">
                                        </div>
                                    @else
                                        <br><br><br>
                                    @endif

                                    <p class="fw-bold text-decoration-underline">SULMARNI, S.A.P</p>
                                    <p>NIP. 19830310 201001 2 022</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            @if ($verifikasi->jenisSurat->kode_surat === 'SKKM' && $skkm)
                                <a href="{{ route('skkm.print', $skkm->id) }}" class="btn btn-primary me-2"
                                    target="_blank">
                                    <i class="ri-printer-line"></i> Print Surat
                                </a>
                            @endif
                            @if ($verifikasi->barcode)
                                <a href="{{ asset('storage/' . $verifikasi->barcode) }}" class="btn btn-success me-2"
                                    download>
                                    <i class="ri-download-line"></i> Download Barcode
                                </a>
                            @endif
                            <a href="{{ route('surat.check.form') }}?code={{ $verifikasi->barcode_data ?? '' }}"
                                class="btn btn-info" target="_blank">
                                <i class="ri-qr-code-line"></i> Test Verifikasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
