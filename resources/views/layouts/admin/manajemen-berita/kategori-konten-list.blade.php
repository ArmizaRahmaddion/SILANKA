@extends('layouts.dashboard-layouts', ['title' => 'Data Kategori Konten'])
@section('content-dashboard')
    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="header-title">
                        <h4 class="card-title mb-0 text-dark fw-bold">
                            <i class="ri-add-circle-line me-2 text-success"></i>Form Tambah Kategori
                        </h4>
                        <p class="text-muted mb-0 small">Tambah kategori konten baru</p>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori-koten.store') }}" method="POST" id="formTambahKategori">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                                class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori"
                                placeholder="Masukkan nama kategori..." autocomplete="off">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100" id="btnSimpan">
                            <i class="ri-save-line me-2"></i>Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0 text-dark fw-bold">
                                <i class="ri-list-check-2 me-2 text-primary"></i>Data Kategori Konten
                            </h4>
                            <p class="text-muted mb-0 small">Kelola kategori konten yang tersedia</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark">
                                <i class="ri-bookmark-line me-1"></i>{{ $kategoris->count() }} Kategori
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($kategoris->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" id="kategoriTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th>Nama Kategori</th>
                                        <th>Slug</th>
                                        <th class="text-center">Jumlah Konten</th>
                                        <th class="text-center" style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategoris as $kategori)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="ri-bookmark-line text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $kategori->nama_kategori }}</div>
                                                        <small class="text-muted">Dibuat
                                                            {{ $kategori->created_at->format('d M Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <code class="bg-light px-2 py-1 rounded">{{ $kategori->slug }}</code>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark">
                                                    {{ $kategori->kontens()->count() }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $kategori->id }}"
                                                        title="Edit Kategori">
                                                        <i class="ri-edit-2-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $kategori->id }}"
                                                        title="Hapus Kategori">
                                                        <i class="ri-delete-bin-2-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-bookmark-line display-4 text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-3">Belum ada kategori konten</h5>
                            <p class="text-muted mb-0">Mulai buat kategori konten pertama Anda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Kategori --}}
    @foreach ($kategoris as $kategori)
        <div class="modal fade" id="editModal{{ $kategori->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $kategori->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $kategori->id }}">
                            <i class="ri-edit-2-line me-2"></i>Edit Kategori
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kategori-koten.update', $kategori) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_nama_kategori{{ $kategori->id }}" class="form-label fw-semibold">
                                    Nama Kategori <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}"
                                    class="form-control" id="edit_nama_kategori{{ $kategori->id }}"
                                    placeholder="Masukkan nama kategori..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Slug Saat Ini</label>
                                <code class="bg-light px-2 py-1 rounded d-block">{{ $kategori->slug }}</code>
                                <small class="text-muted">Slug akan otomatis diperbarui berdasarkan nama kategori</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ri-close-line me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="ri-save-line me-2"></i>Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Delete Kategori --}}
        <div class="modal fade" id="deleteModal{{ $kategori->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $kategori->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger" id="deleteModalLabel{{ $kategori->id }}">
                            <i class="ri-delete-bin-2-line me-2"></i>Hapus Kategori
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-4">
                            <i class="ri-error-warning-line display-4 text-warning"></i>
                        </div>
                        <h5 class="mb-3">Apakah Anda yakin?</h5>
                        <p class="text-muted mb-3">
                            Kategori "<strong>{{ $kategori->nama_kategori }}</strong>" akan dihapus secara permanen.
                        </p>
                        @if ($kategori->kontens()->count() > 0)
                            <div class="alert alert-warning">
                                <i class="ri-alert-line me-2"></i>
                                Kategori ini memiliki <strong>{{ $kategori->kontens()->count() }}</strong> konten terkait
                                dan tidak dapat dihapus.
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                Tindakan ini tidak dapat dibatalkan.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-2"></i>Batal
                        </button>
                        @if ($kategori->kontens()->count() == 0)
                            <form action="{{ route('kategori-koten.destroy', $kategori) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ri-delete-bin-2-line me-2"></i>Ya, Hapus!
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Custom Styles --}}
    <style>
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-outline-warning:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .modal-content {
            border-radius: 12px;
        }
    </style>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
    </div>
@endsection
