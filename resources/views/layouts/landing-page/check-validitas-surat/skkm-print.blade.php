<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>SKKM - Surat Keterangan Meninggal Dunia</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.5;
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 2cm;
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
            margin-bottom: 10px;
            margin-top: -55px;
        }

        .kop-logo {
            min-width: 126%;
            height: 100%;
            max-height: 6cm;
        }

        .document-title {
            margin-top: 20px;
            font-size: 14pt;
        }

        .document-number {
            margin-bottom: 30px;
        }

        .content {
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
        }

        .dot-line {
            display: inline-block;
            padding: 0 2px;
            line-height: 1.2;
        }

        .signature-section {
            margin-top: 60px;
            width: 100%;
            overflow: auto;
            page-break-inside: avoid;
            position: relative;
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

        .signature-title {
            margin-bottom: 20px;
        }

        .barcode-container {
            text-align: center;
            margin: 30px 0;
        }

        .barcode-image {
            width: 100px;
            height: 100px;
        }

        .signature-name-section {
            margin-top: 30px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .verification-info {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 1000;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 12px;
            max-width: 200px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin-top: 0.5cm;
                /* ruang cukup agar kop tidak terpotong */
                margin-right: 1.5cm;
                margin-bottom: 1.5cm;
                margin-left: 1.5cm;
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 11.5pt;
                line-height: 1.4;
                width: auto;
                height: auto;
                overflow: visible;
            }

            .kop-logo {
                display: block;
                min-width: 126%;
                max-height: 6cm;
                /* jaga agar logo tetap terlihat utuh */
                object-fit: contain;
                margin-top: 0;
                /* pastikan tidak ada margin atas */
                margin-bottom: 10px;
            }

            .header {
                margin-top: 0;
                padding-top: 0;
                page-break-inside: avoid;
            }

            .print-button,
            .back-button,
            .verification-info {
                display: none;
            }

            * {
                color: #000 !important;
                background: transparent !important;
                box-shadow: none !important;
                overflow: visible !important;
                page-break-inside: avoid !important;
            }

            p,
            .data-row,
            .signature-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <button class="print-button" onclick="window.print()">
        <i class="ri-printer-line"></i> Print Surat
    </button>

    <a href="javascript:history.back()" class="back-button">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>

    <div class="verification-info">
        <strong>✓ Surat Terverifikasi</strong><br>
        <small>{{ $verifikasi->verified_at->format('d/m/Y H:i') }}</small>
    </div>

    <div class="header">
        <img src="{{ asset('assets/images/kokop.png') }}" alt="Kop Surat Pemerintah" class="kop-logo" />
    </div>

    <div class="center document-title bold underline">
        SURAT KETERANGAN MENINGGAL DUNIA
    </div>
    <div class="center document-number">
        Nomor : {{ $verifikasi->suratTerbit->nomor_surat }}
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan di bawah ini PJ. Wali Nagari Koto Alam Kecamatan
            Pangkalan Koto Baru Kabupaten Lima Puluh Kota menerangkan bahwa:
        </p>

        <div class="data-table">
            <div class="data-row">
                <div class="data-label">Nama</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $suratData->nama_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">NIK</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $suratData->nik_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Tempat/ Tgl Lahir</div>
                <div class="data-separator">:</div>
                <div class="data-value">
                    {{ $suratData->tempat_lahir_almarhum }},
                    {{ \Carbon\Carbon::parse($suratData->tanggal_lahir_almarhum)->translatedFormat('d F Y') }}
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Jenis Kelamin</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $suratData->jenis_kelamin_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Agama</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $suratData->agama_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Alamat</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $suratData->alamat_almarhum }}</div>
            </div>
        </div>

        <p>
            Berdasarkan pernyataan dari pihak keluarga, bahwa nama yang tersebut di
            atas benar penduduk Jorong <span class="dot-line">{{ $suratData->alamat_almarhum }}</span> Nagari Koto
            Alam yang telah meninggal dunia pada tanggal
            <span
                class="dot-line">{{ \Carbon\Carbon::parse($suratData->tanggal_meninggal)->translatedFormat('d') }}</span>
            bulan
            <span
                class="dot-line">{{ \Carbon\Carbon::parse($suratData->tanggal_meninggal)->translatedFormat('F') }}</span>
            tahun
            <span
                class="dot-line">{{ \Carbon\Carbon::parse($suratData->tanggal_meninggal)->translatedFormat('Y') }}</span>,
            di
            Nagari Koto Alam.
        </p>

        <p>
            Demikianlah Surat Keterangan Meninggal Dunia ini kami berikan untuk
            dapat digunakan seperlunya.
        </p>
    </div>

    <div class="signature-section">
        <div class="signature-right">
            Dikeluarkan di : Koto Alam<br />
            Pada Tanggal : <span
                class="dot-line">{{ \Carbon\Carbon::parse($verifikasi->suratTerbit->tanggal_terbit ?? now())->format('d F Y') }}</span><br /><br />

            <div class="signature-title">PJ. Wali Nagari Koto Alam</div>

            @if ($verifikasi->barcode)
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
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }

        window.onafterprint = function() {
            // window.close();
        }
    </script>
</body>

</html>
