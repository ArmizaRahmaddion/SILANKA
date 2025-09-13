<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Verifikasi Surat - Nagari Koto Alam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #008374 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .check-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .check-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .check-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .check-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-check {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-check:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #4CAF50;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="check-container">
        <div class="check-card">
            <div class="check-header">
                <i class="ri-shield-check-line" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3 class="mb-0">Verifikasi Surat</h3>
                <p class="mb-0 mt-2">Nagari Koto Alam</p>
            </div>

            <div class="check-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-check-line"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('surat.check.process') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nomor_surat" class="form-label fw-bold">
                            <i class="ri-file-text-line"></i> Nomor Surat
                        </label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                            id="nomor_surat" name="nomor_surat"
                            placeholder="Masukkan nomor surat (contoh: 001/SKKM/WN-KA/2024)"
                            value="{{ old('nomor_surat') }}" required>
                        @error('nomor_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-check">
                            <i class="ri-search-line"></i> Cek Verifikasi Surat
                        </button>
                    </div>
                </form>

                <div class="info-box mt-4">
                    <h6 class="fw-bold mb-2">
                        <i class="ri-information-line"></i> Informasi
                    </h6>
                    <ul class="mb-0 small">
                        <li>Masukkan nomor surat yang tertera pada dokumen</li>
                        <li>Sistem akan memverifikasi keaslian surat</li>
                        <li>Hanya surat yang telah diverifikasi yang dapat dicek</li>
                    </ul>
                </div>

                @if ($code)
                    <div class="alert alert-info mt-3">
                        <i class="ri-qr-code-line"></i>
                        <strong>QR Code terdeteksi!</strong><br>
                        Silakan masukkan nomor surat untuk verifikasi.
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="text-white text-decoration-none">
                <i class="ri-home-line"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
