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
            /* border-bottom: 1px dotted #000; */
            padding: 0 2px;
            /* Sedikit ruang di kiri dan kanan */
            line-height: 1.2;
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

        @media print {
            body {
                padding: 1cm;
                margin: 0;
                width: auto;
                min-height: auto;
            }

            .kop-logo {
                max-height: 4cm;
                min-width: 126%;
            }

            .print-button {
                display: none;
            }

            @page {
                size: A4;
                margin: 1.5cm;
            }

            * {
                color: #000 !important;
                background: transparent !important;
                box-shadow: none !important;
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
        SURAT KETERANGAN MENINGGAL DUNIA
    </div>
    <div class="center document-number">
        Nomor : {{ $suratTerbit->nomor_surat ?? 'XXX/SKKM/WN-KA/' . date('Y') }}
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
                <div class="data-value">{{ $skkm->nama_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">NIK</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $skkm->nik_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Tempat/ Tgl Lahir</div>
                <div class="data-separator">:</div>
                <div class="data-value">
                    {{ $skkm->tempat_lahir_almarhum }},
                    {{ \Carbon\Carbon::parse($skkm->tanggal_lahir_almarhum)->translatedFormat('d F Y') }}
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Jenis Kelamin</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $skkm->jenis_kelamin_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Agama</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $skkm->agama_almarhum }}</div>
            </div>
            <div class="data-row">
                <div class="data-label">Alamat</div>
                <div class="data-separator">:</div>
                <div class="data-value">{{ $skkm->alamat_almarhum }}</div>
            </div>
        </div>

        <p>
            Berdasarkan pernyataan dari pihak keluarga, bahwa nama yang tersebut di
            atas benar penduduk Jorong <span class="dot-line">{{ $skkm->alamat_almarhum }}</span> Nagari Koto
            Alam yang telah meninggal dunia pada tanggal
            <span class="dot-line">{{ \Carbon\Carbon::parse($skkm->tanggal_meninggal)->translatedFormat('d') }}</span>
            bulan
            <span class="dot-line">{{ \Carbon\Carbon::parse($skkm->tanggal_meninggal)->translatedFormat('F') }}</span>
            tahun
            <span class="dot-line">{{ \Carbon\Carbon::parse($skkm->tanggal_meninggal)->translatedFormat('Y') }}</span>,
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
            Pada Tanggal :
            @php
                \Carbon\Carbon::setLocale('id');
            @endphp
            <span class="dot-line">
                {{ \Carbon\Carbon::parse($suratTerbit->tanggal_terbit ?? now())->translatedFormat('d F Y') }}
            </span><br /><br />


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
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }

        // Close window after printing (optional)
        window.onafterprint = function() {
            // window.close();
        }
    </script>
</body>

</html>
