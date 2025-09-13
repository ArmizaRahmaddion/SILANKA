@extends('layouts.dashboard-layouts')

@section('content-dashboard')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="header-title">
                            <h4 class="card-title">Preview Surat Keterangan Tidak Mampu</h4>
                            <p class="mb-0 text-muted">{{ $sktm->nama }} -
                                {{ $suratTerbit->nomor_surat ?? 'Belum ada nomor' }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('sktm.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Kembali
                            </a>
                            @if ($suratTerbit)
                                <a href="{{ route('sktm.print', $sktm->id) }}" class="btn btn-primary" target="_blank">
                                    <i class="ri-printer-line"></i> Print Surat
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Preview Container -->
                        <div id="preview-container" class="preview-wrapper">
                            <div class="surat-container">
                                <div class="header-surat">
                                    <img src="{{ asset('assets/images/kokop.png') }}" alt="Kop Surat Pemerintah"
                                        class="kop-logo" />
                                </div>

                                <div class="center document-title bold underline">
                                    SURAT KETERANGAN TIDAK MAMPU
                                </div>
                                <div class="center document-number">
                                    Nomor : {{ $suratTerbit->nomor_surat ?? 'XXX/sktm/WN-KA/' . date('Y') }}
                                </div>

                                <div class="content-surat">
                                    <p>Yang bertanda tangan dibawah ini Pj. Wali Nagari Koto Alam Kecamatan Pangkalan Koto
                                        Baru Kabupaten Lima Puluh
                                        Kota dengan ini menerangkan bahwa:</p>

                                    <!-- Anak -->
                                    <div class="data-row">
                                        <div class="data-label">Nama</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_nama }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">NIK</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_nik }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Tempat/Tgl Lahir</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_tempat_lahir }},
                                            {{ \Carbon\Carbon::parse($sktm->anak_tanggal_lahir)->translatedFormat('d F Y') }}
                                        </div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Jenis Kelamin</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_jenis_kelamin }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Pekerjaan</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_pekerjaan }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Status Perkawinan</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_status_perkawinan }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Alamat</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->anak_alamat }}</div>
                                    </div>


                                    <!-- Orang Tua -->
                                    <p><strong>Adalah Anak dari:</strong></p>

                                    <div class="data-row">
                                        <div class="data-label">Nama</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_nama }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">NIK</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_nik }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Tempat/Tgl Lahir</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_tempat_lahir }},
                                            {{ \Carbon\Carbon::parse($sktm->ortu_tanggal_lahir)->translatedFormat('d F Y') }}
                                        </div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Jenis Kelamin</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_jenis_kelamin }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Pekerjaan</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_pekerjaan }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Status Perkawinan</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_status_perkawinan }}</div>
                                    </div>
                                    <div class="data-row">
                                        <div class="data-label">Alamat</div>
                                        <div class="data-separator">:</div>
                                        <div class="data-value">{{ $sktm->ortu_alamat }}</div>
                                    </div>


                                    <p>Dengan ini menerangkan bahwa nama tersebut diatas benar adalah Penduduk Nagari Koto
                                        Alam yang mana
                                        termasuk
                                        Data Keluarga Tidak Mampu Tahun 2025. Sehingga segala pungutan dari Nagari
                                        dibebaskan yang mempunyai
                                        tanggung jawab sebagai berikut:</p>

                                    <table class="family-table">
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

                                <div class="signature-section">
                                    <div class="signature-right">
                                        Dikeluarkan di : Koto Alam<br />
                                        Pada Tanggal : @php
                                            \Carbon\Carbon::setLocale('id');
                                        @endphp
                                        <span class="dot-line">
                                            {{ \Carbon\Carbon::parse($suratTerbit->tanggal_terbit ?? now())->translatedFormat('d F Y') }}
                                        </span><br /><br />
                                        PJ. Wali Nagari Koto Alam<br /><br /><br /><br /><br />
                                        <div class="signature-name">SULMARNI, S.A.P</div>
                                        <div>NIP. 19830310 201001 2 022</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Panel -->
                        <div class="info-panel mt-4 p-4 bg-light">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Informasi Surat</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="150">Status</td>
                                            <td>:</td>
                                            <td>
                                                @switch($sktm->permintaanSurat->status)
                                                    @case('Diproses')
                                                        <span class="badge bg-warning">{{ $sktm->permintaanSurat->status }}</span>
                                                    @break

                                                    @case('Diterima')
                                                        <span class="badge bg-success">{{ $sktm->permintaanSurat->status }}</span>
                                                    @break

                                                    @case('Ditolak')
                                                        <span class="badge bg-danger">{{ $sktm->permintaanSurat->status }}</span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="badge bg-secondary">{{ $sktm->permintaanSurat->status }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Permintaan</td>
                                            <td>:</td>
                                            @php
                                                \Carbon\Carbon::setLocale('id');
                                            @endphp
                                            <td>{{ \Carbon\Carbon::parse($sktm->permintaanSurat->tanggal_permintaan)->translatedformat('d F Y') }}
                                            </td>
                                        </tr>
                                        @if ($suratTerbit)
                                            <tr>
                                                <td>Tanggal Diterima</td>
                                                <td>:</td>
                                                @php
                                                    \Carbon\Carbon::setLocale('id');
                                                @endphp
                                                <td>{{ \Carbon\Carbon::parse($suratTerbit->tanggal_terbit)->translatedformat('d F Y H:i') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Data Pemohon</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="150">Nama</td>
                                            <td>:</td>
                                            <td>{{ $sktm->permintaanSurat->verifikasiPengguna->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td width="150">Keperluan</td>
                                            <td>:</td>
                                            <td>{{ $sktm->keperluan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Surat</td>
                                            <td>:</td>
                                            <td>{{ $sktm->permintaanSurat->jenisSurat->nama_surat ?? 'sktm' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .preview-wrapper {
            background: #f8f9fa;
            padding: 20px;
            min-height: 80vh;
        }

        .surat-container {
            background: white;
            max-width: 21cm;
            margin: 0 auto;
            padding: 2cm;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        .header-surat {
            text-align: center;
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            margin-top: -55px;
        }

        .kop-logo {
            min-width: 126%;
            height: 100%;
            max-height: 6cm;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .document-title {
            margin-top: 20px;
            font-size: 14pt;
        }

        .document-number {
            margin-bottom: 30px;
        }

        .content-surat {
            text-align: justify;
            margin-top: 20px;
        }

        .data-table {
            margin: 20px 0 40px 60px;
            width: 100%;
        }

        .data-row {
            display: flex;
            margin-bottom: 8px;
        }

        .data-label {
            width: 160px;
            flex-shrink: 0;
        }

        .data-separator {
            width: 10px;
            text-align: center;
            flex-shrink: 0;
        }

        .data-value {
            flex: 1;
            font-weight: 500;
        }

        .dot-line {
            display: inline-block;
            /* border-bottom: 1px dotted #000; */
            padding: 0 2px;
            /* Sedikit ruang di kiri dan kanan */
            line-height: 1.2;
        }

        .family-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 8px;
        }

        .family-table th,
        .family-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .family-table th {
            background-color: #f0f0f0;
        }

        .signature-section {
            margin-top: 60px;
            width: 100%;
            overflow: auto;
            page-break-inside: avoid;
        }

        .signature-right {
            float: right;
            text-align: left;
            width: 250px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .info-panel {
            border-top: 3px solid #007bff;
            border-radius: 0 0 8px 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .surat-container {
                padding: 1cm;
                margin: 0 10px;
            }

            .kop-logo {
                max-height: 4cm;
                min-width: 126%;
            }

            .data-table {
                margin-left: 20px;
            }

            .signature-right {
                width: 200px;
            }
        }

        /* Print styles for preview */
        @media print {
            .preview-wrapper {
                background: white;
                padding: 0;
            }

            .surat-container {
                box-shadow: none;
                margin: 0;
                padding: 1cm;
            }

            .info-panel {
                display: none;
            }

            .card-header {
                display: none;
            }

            @page {
                size: A4;
                margin: 1.5cm;
            }
        }
    </style>

    <script>
        function printPreview() {
            // Hide elements that shouldn't be printed
            const elementsToHide = [
                '.card-header',
                '.info-panel',
                '.btn',
                '.navbar',
                '.sidebar'
            ];

            elementsToHide.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    el.style.display = 'none';
                });
            });

            // Print
            window.print();

            // Restore hidden elements after print
            setTimeout(() => {
                elementsToHide.forEach(selector => {
                    const elements = document.querySelectorAll(selector);
                    elements.forEach(el => {
                        el.style.display = '';
                    });
                });
            }, 1000);
        }

        // Auto-adjust container height
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.surat-container');
            if (container) {
                const minHeight = window.innerHeight - 200;
                container.style.minHeight = minHeight + 'px';
            }
        });
    </script>
@endsection
