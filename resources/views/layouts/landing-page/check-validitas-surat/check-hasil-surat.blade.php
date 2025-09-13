<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Verifikasi Surat - Nagari Koto Alam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #008374 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .result-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .result-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .result-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .verification-badge {
            background: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: bold;
            display: inline-block;
            margin: 1rem 0;
        }

        .info-table {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .btn-action {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            margin: 0.25rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="result-container">
        <div class="result-card">
            <div class="result-header no-print">
                <i class="ri-shield-check-fill" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                <h3 class="mb-0">Surat Terverifikasi</h3>
                <div class="verification-badge">
                    <i class="ri-check-double-line"></i> VALID & TERVERIFIKASI
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Informasi Surat -->
                <div class="info-table">
                    <h5 class="fw-bold mb-3">
                        <i class="ri-file-text-line"></i> Informasi Surat
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nomor Surat:</strong></td>
                                    <td>{{ $suratTerbit->nomor_surat }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Surat:</strong></td>
                                    <td>{{ $verifikasi->jenisSurat->nama_surat }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-success">Terverifikasi</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Diverifikasi:</strong></td>
                                    <td>{{ $verifikasi->verified_at->translatedformat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Oleh:</strong></td>
                                    <td>{{ $verifikasi->verifiedBy->name ?? 'System' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                @switch($verifikasi->jenisSurat->kode_surat)
                    @case('SKKM')
                        @if ($suratData)
                            <div class="info-table">
                                <h5 class="fw-bold mb-3">
                                    <i class="ri-user-line"></i> Detail Surat Keterangan Meninggal Dunia
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama Almarhum:</strong></td>
                                                <td>{{ $suratData->nama_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK:</strong></td>
                                                <td>{{ $suratData->nik_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tempat Lahir:</strong></td>
                                                <td>{{ $suratData->tempat_lahir_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Lahir:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($suratData->tanggal_lahir_almarhum)->format('d F Y') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Jenis Kelamin:</strong></td>
                                                <td>{{ $suratData->jenis_kelamin_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Agama:</strong></td>
                                                <td>{{ $suratData->agama_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td>{{ $suratData->alamat_almarhum }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Meninggal:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($suratData->tanggal_meninggal)->format('d F Y') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break

                    @case('SKD')
                        @if ($suratData)
                            <div class="info-table">
                                <h5 class="fw-bold mb-3">
                                    <i class="ri-user-location-line"></i> Detail Surat Keterangan Domisili
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td>{{ $suratData->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK:</strong></td>
                                                <td>{{ $suratData->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Kelamin</strong></td>
                                                <td>{{ $suratData->jenis_kelamin }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Status Perkawinan</strong></td>
                                                <td>{{ $suratData->status_perkawinan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Agama:</strong></td>
                                                <td>{{ $suratData->agama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pekerjaan:</strong></td>
                                                <td>{{ $suratData->pekerjaan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td>{{ $suratData->alamat }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break

                    @case('SKU')
                        @if ($suratData)
                            <div class="info-table">
                                <h5 class="fw-bold mb-3">
                                    <i class="ri-user-location-line"></i> Detail Surat Keterangan Usaha
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td>{{ $suratData->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK:</strong></td>
                                                <td>{{ $suratData->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Kelamin</strong></td>
                                                <td>{{ $suratData->jenis_kelamin }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Status Perkawinan</strong></td>
                                                <td>{{ $suratData->status_perkawinan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Agama:</strong></td>
                                                <td>{{ $suratData->agama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pekerjaan:</strong></td>
                                                <td>{{ $suratData->pekerjaan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td>{{ $suratData->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Usaha:</strong></td>
                                                <td>{{ $suratData->jenis_usaha }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Luas Usaha:</strong></td>
                                                <td>{{ $suratData->luas_usaha }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break

                    @case('SKTM')
                        @if ($suratData)
                            <div class="info-table">
                                <h5 class="fw-bold mb-3">
                                    <i class="ri-user-location-line"></i> Detail Surat Keterangan Tidak Mampu
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td>{{ $suratData->anak_nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK:</strong></td>
                                                <td>{{ $suratData->anak_nik }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Kelamin</strong></td>
                                                <td>{{ $suratData->anak_jenis_kelamin }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Status Perkawinan</strong></td>
                                                <td>{{ $suratData->anak_status_perkawinan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pekerjaan:</strong></td>
                                                <td>{{ $suratData->anak_pekerjaan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td>{{ $suratData->anak_alamat }}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break

                    {{-- Tambahkan jenis surat lain di sini --}}

                    @default
                        <div class="info-table">
                            <p class="text-muted">Jenis surat belum didukung untuk ditampilkan.</p>
                        </div>

                @endswitch


                <!-- Barcode -->
                @if ($verifikasi->barcode)
                    <div class="text-center info-table">
                        <h5 class="fw-bold mb-3">
                            <i class="ri-qr-code-line"></i> Barcode Verifikasi
                        </h5>
                        <img src="{{ asset('storage/' . $verifikasi->barcode) }}" alt="Barcode Verifikasi"
                            style="width: 200px; height: 200px;">
                        <p class="text-muted mt-2">Barcode ini membuktikan keaslian surat</p>
                    </div>
                @endif

                <!-- Actions -->
                <div class="text-center mt-4 no-print">
                    <a href="{{ route('surat.check.form') }}" class="btn btn-primary btn-action">
                        <i class="ri-search-line"></i> Cek Surat Lain
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-secondary btn-action">
                        <i class="ri-home-line"></i> Kembali ke Beranda
                    </a>
                    <a href="{{ route('surat.print.from.check', $verifikasi->id) }}" class="btn btn-success btn-action"
                        target="_blank">
                        <i class="ri-printer-line"></i> Print Surat
                    </a>
                    <button onclick="window.print()" class="btn btn-info btn-action">
                        <i class="ri-file-text-line"></i> Print Hasil Verifikasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
