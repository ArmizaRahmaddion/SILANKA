<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>SKTM - Surat Keterangan Tidak Mampu</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 10.5pt;
            line-height: 1.4;
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 1.2cm;
            background: white;
            color: #000;
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

        .header {
            text-align: center;
            display: flex;
            justify-content: center;
            margin-bottom: 6px;
            margin-top: -40px;
        }

        .kop-logo {
            min-width: 126%;
            max-height: 4.5cm;
        }

        .document-title {
            margin-top: 8px;
            font-size: 13pt;
        }

        .document-number {
            margin-bottom: 12px;
        }

        .content {
            text-align: justify;
        }

        .data-row {
            display: flex;
            margin-bottom: 3px;
        }

        .data-label {
            width: 150px;
            flex-shrink: 0;
        }

        .data-separator {
            width: 10px;
            text-align: center;
            flex-shrink: 0;
        }

        .data-value {
            flex: 1;
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
            margin-top: 20px;
            width: 100%;
            overflow: auto;
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

        .barcode-container {
            margin-top: 6px;
            margin-bottom: 4px;
        }

        .barcode-image {
            width: 100px;
            height: auto;
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                padding: 1.2cm;
                margin: 0;
                width: auto;
            }

            .kop-logo {
                max-height: 4.2cm;
            }

            @page {
                size: A4;
                margin: 1.2cm;
            }
        }
    </style>

</head>

<body>
    <button class="print-button" onclick="window.print()">Print Surat</button>
    <div class="header">
        <img src="{{ asset('assets/images/kokop.png') }}" alt="Kop Surat Pemerintah" class="kop-logo" />
    </div>

    <div class="center document-title bold underline">
        SURAT KETERANGAN TIDAK MAMPU
    </div>
    <div class="center document-number">
        <strong> NOMOR: {{ $suratTerbit->nomor_surat ?? 'XXX/SKTM/WN-KA/2025' . date('Y') }}</strong>
    </div>

    <div class="content">
        <p>Yang bertanda tangan dibawah ini Pj. Wali Nagari Koto Alam Kecamatan Pangkalan Koto Baru Kabupaten Lima Puluh
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
                {{ \Carbon\Carbon::parse($sktm->anak_tanggal_lahir)->translatedFormat('d F Y') }}</div>
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
                {{ \Carbon\Carbon::parse($sktm->ortu_tanggal_lahir)->translatedFormat('d F Y') }}</div>
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


        <p>Dengan ini menerangkan bahwa nama tersebut diatas benar adalah Penduduk Nagari Koto Alam yang mana
            termasuk
            Data Keluarga Tidak Mampu Tahun 2025. Sehingga segala pungutan dari Nagari dibebaskan yang mempunyai
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

        <p>Demikianlah Surat Keterangan Tidak Mampu ini kami berikan agar dapat digunakan seperlunya.</p>
    </div>

    <div class="signature-section">
        <div class="signature-right">
            Dikeluarkan di: Koto Alam<br />
            Pada Tanggal:
            {{ \Carbon\Carbon::parse($suratTerbit->tanggal_terbit ?? now())->translatedFormat('d F Y') }}<br><br>

            <div class="signature-title">PJ. Wali Nagari Koto Alam</div>

            @if ($verifikasi && $verifikasi->barcode)
                <div class="barcode-container">
                    <img src="{{ asset('storage/' . $verifikasi->barcode) }}" alt="Barcode Verifikasi"
                        class="barcode-image">
                </div>
            @else
                <br><br><br>
            @endif

            <div class="signature-name-section">
                <div class="signature-name">SULMARNI, S.A.P</div>
                <div>NIP. 19830310 201001 2 022</div>
            </div>
        </div>
    </div>

    <script>
        window.onafterprint = function() {
            // window.close(); // opsional
        }
    </script>
</body>

</html>
