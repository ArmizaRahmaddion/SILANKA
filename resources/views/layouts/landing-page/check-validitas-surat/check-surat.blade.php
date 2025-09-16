<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek SILANKA - Nagari Koto Alam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #43cea2 0%, #185a9d 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .check-container {
            max-width: 430px;
            margin: 0 auto;
            padding: 2.5rem 1.2rem;
        }

        .check-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 22px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            overflow: hidden;
            border: 1.5px solid #e3e3e3;
            animation: fadeInUp 0.7s cubic-bezier(.39, .575, .56, 1.000);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .check-header {
            background: linear-gradient(120deg, #43cea2 0%, #185a9d 100%);
            color: white;
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
            text-align: center;
            border-bottom-left-radius: 40px 20px;
            border-bottom-right-radius: 40px 20px;
        }

        .check-header i {
            font-size: 3.2rem;
            margin-bottom: 0.7rem;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.12));
        }

        .check-header h3 {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .check-header p {
            font-size: 1.1rem;
            opacity: 0.92;
        }

        .check-body {
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #185a9d;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 13px 16px;
            font-size: 16px;
            background: #f7fafc;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #43cea2;
            box-shadow: 0 0 0 0.18rem rgba(67, 206, 162, 0.18);
        }

        /* .btn-check {
            background: linear-gradient(120deg, #43cea2 0%, #185a9d 100%);
            border: none;
            border-radius: 12px;
            padding: 13px 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
            font-size: 1.08rem;
            box-shadow: 0 4px 16px rgba(67, 206, 162, 0.13);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-check:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 24px rgba(24, 90, 157, 0.18);
        } */

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #43cea2;
            padding: 1.1rem 1rem;
            margin: 1.2rem 0 0.5rem 0;
            border-radius: 7px;
            font-size: 0.98rem;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.97rem;
        }

        .text-center.mt-4 a {
            font-weight: 600;
            font-size: 1.05rem;
            opacity: 0.93;
            transition: color 0.2s;
        }

        .text-center.mt-4 a:hover {
            color: #43cea2;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="check-container">
        <div class="check-card">
            <div class="check-header">
                <i class="ri-shield-check-line" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3 class="mb-0">SILANKA</h3>
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

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
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

                {{-- @if ($code)
                    <div class="alert alert-info mt-3">
                        <i class="ri-qr-code-line"></i>
                        <strong>QR Code terdeteksi!</strong><br>
                        Silakan masukkan nomor surat untuk verifikasi.
                    </div>
                @endif --}}
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="text-white text-decoration-none">
                <i class="ri-home-line"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
