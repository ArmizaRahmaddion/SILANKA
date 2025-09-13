@extends('layouts.dashboard-layouts', ['title' => 'Manajemen Konten'])

@section('content-dashboard')
    {{-- Success & Error Messages --}}
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
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 mb-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0 text-dark fw-bold">
                                <i class="ri-article-line me-2 text-primary"></i>Manajemen Konten
                            </h4>
                            <p class="text-muted mb-0 small">Kelola semua konten artikel dan berita</p>
                        </div>
                        <a href="{{ route('konten.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-2"></i>Tambah Konten
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($kontens->count() > 0)
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-hover mb-0" data-toggle="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3 border-0">#</th>
                                        <th class="px-4 py-3 border-0">Konten</th>
                                        <th class="px-4 py-3 border-0">Kategori</th>
                                        <th class="px-4 py-3 border-0">Penulis</th>
                                        <th class="px-4 py-3 border-0">Status</th>
                                        <th class="px-4 py-3 border-0">Tanggal</th>
                                        <th class="px-4 py-3 border-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kontens as $konten)
                                        <tr class="align-middle">
                                            <td class="px-4 py-3">
                                                <span
                                                    class="text-muted fw-medium">{{ $loop->iteration + ($kontens->currentPage() - 1) * $kontens->perPage() }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if ($konten->image)
                                                        <img src="{{ asset('storage/' . $konten->image) }}" alt="Thumbnail"
                                                            class="rounded me-3"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="ri-image-line text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1 fw-medium">{{ Str::limit($konten->title, 40) }}</h6>
                                                        <small class="text-muted">{{ $konten->slug }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="badge bg-light text-dark">{{ $konten->kategoriKoten->nama_kategori }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-muted">{{ $konten->author ?? 'Admin' }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                        role="switch" data-konten-id="{{ $konten->id }}"
                                                        {{ $konten->status === 'published' ? 'checked' : '' }}>
                                                    <label class="form-check-label small">
                                                        <span
                                                            class="status-text">{{ $konten->status === 'published' ? 'Published' : 'Draft' }}</span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <small
                                                    class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('konten.show', $konten) }}"
                                                        class="btn btn-sm btn-outline-info" title="Preview">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('konten.edit', $konten) }}"
                                                        class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="ri-edit-2-line"></i>
                                                    </a>
                                                    <form action="{{ route('konten.destroy', $konten) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Hapus">
                                                            <i class="ri-delete-bin-2-line"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($kontens->hasPages())
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Menampilkan {{ $kontens->firstItem() }} - {{ $kontens->lastItem() }} dari
                                        {{ $kontens->total() }} data
                                    </small>
                                    {{ $kontens->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-article-line" style="font-size: 4rem; color: #e9ecef;"></i>
                            </div>
                            <h5 class="text-muted mb-3">Belum ada konten</h5>
                            <p class="text-muted mb-4">Mulai buat konten pertama Anda sekarang</p>
                            <a href="{{ route('konten.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Buat Konten
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .status-toggle:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .status-toggle:not(:checked) {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-info:hover,
        .btn-outline-warning:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

    {{-- JavaScript for Status Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusToggles = document.querySelectorAll('.status-toggle');

            statusToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const kontenId = this.dataset.kontenId;
                    const newStatus = this.checked ? 'published' : 'draft';
                    const statusText = this.parentNode.querySelector('.status-text');

                    // Disable toggle during request
                    this.disabled = true;

                    fetch(`/konten/${kontenId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                statusText.textContent = newStatus === 'published' ?
                                    'Published' : 'Draft';

                                // Show success toast (if you have toast notification system)
                                // You can implement a toast notification here
                            } else {
                                // Revert toggle state on error
                                this.checked = !this.checked;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revert toggle state on error
                            this.checked = !this.checked;
                        })
                        .finally(() => {
                            this.disabled = false;
                        });
                });
            });
        });
    </script>
@endsection
