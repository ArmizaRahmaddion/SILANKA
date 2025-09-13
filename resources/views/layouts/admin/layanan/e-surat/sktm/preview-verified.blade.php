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
                                    @if ($verifikasi->jenisSurat->kode_surat === 'SKTM')
                                        SURAT KETERANGAN TIDAK MAMPU
                                    @else
                                        {{ strtoupper($verifikasi->jenisSurat->nama_surat) }}
                                    @endif
                                </h5>
                                <p class="mb-0">Nomor : {{ $verifikasi->suratTerbit->nomor_surat }}</p>
                            </div>

                            @if ($verifikasi->jenisSurat->kode_surat === 'SKTM' && $suratTerbit)
                                <!-- Content Surat -->
                                <div class="content-section">
                                    <p>Yang bertanda tangan dibawah ini Pj. Wali Nagari Koto Alam Kecamatan Pangkalan Koto
                                        Baru Kabupaten Lima Puluh
                                        Kota dengan ini menerangkan bahwa:</p>

                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Nama</strong></td>
                                                    <td width="10">:</td>
                                                    <td>{{ $sktm->anak_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_nik }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tempat/ Tgl Lahir</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_tempat_lahir }},
                                                        {{ \Carbon\Carbon::parse($sktm->anak_tanggal_lahir)->translatedFormat('d F Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis Kelamin</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_jenis_kelamin }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pekerjaan</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_pekerjaan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status Perkawinan</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_status_perkawinan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Alamat</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->anak_alamat }}</td>
                                                </tr>
                                            </table>
                                            <p><strong>Adalah Anak dari:</strong></p>
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Nama</strong></td>
                                                    <td width="10">:</td>
                                                    <td>{{ $sktm->ortu_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_nik }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tempat/ Tgl Lahir</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_tempat_lahir }},
                                                        {{ \Carbon\Carbon::parse($sktm->ortu_tanggal_lahir)->translatedFormat('d F Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis Kelamin</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_jenis_kelamin }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pekerjaan</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_pekerjaan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status Perkawinan</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_status_perkawinan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Alamat</strong></td>
                                                    <td>:</td>
                                                    <td>{{ $sktm->ortu_alamat }}</td>
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

                                    <p>Dengan ini menerangkan bahwa nama tersebut diatas benar adalah Penduduk Nagari Koto
                                        Alam yang mana
                                        termasuk
                                        Data Keluarga Tidak Mampu Tahun 2025. Sehingga segala pungutan dari Nagari
                                        dibebaskan yang mempunyai
                                        tanggung jawab sebagai berikut:</p>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NAMA</th>
                                                <th>UMUR</th>
                                                <th>PEKERJAAN</th>
                                                <th>KETERANGAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sktm->tanggungJawab as $index => $keluarga)
                                                <tr>
                                                    <td>{{ $index + 1 }}.</td>
                                                    <td>{{ $keluarga->nama }}</td>
                                                    <td>{{ $keluarga->umur }} Tahun</td>
                                                    <td>{{ $keluarga->pekerjaan }}</td>
                                                    <td>{{ $keluarga->keterangan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <p>Demikianlah Surat Keterangan Tidak Mampu ini kami berikan agar dapat digunakan
                                        seperlunya.</p>

                                </div>
                            @endif

                            <!-- Signature Section -->
                            <div class="row mt-5">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-start">
                                    <p>Dikeluarkan di : Koto Alam<br>
                                        Pada Tanggal :
                                        @php
                                            \Carbon\Carbon::setLocale('id');
                                        @endphp
                                        {{ \Carbon\Carbon::parse($verifikasi->suratTerbit->tanggal_terbit ?? now())->translatedformat('d F Y') }}
                                    </p>
                                    <p class="mt-4">PJ. Wali Nagari Koto Alam</p>

                                    @if ($verifikasi->barcode)
                                        <div class="text-center my-4">
                                            <img src="{{ URL::asset('storage/' . $verifikasi->barcode) }}" alt="Barcode"
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
                            @if ($verifikasi->jenisSurat->kode_surat === 'sktm' && $sktm)
                                <a href="{{ route('sktm.print', $sktm->id) }}" class="btn btn-primary me-2"
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
