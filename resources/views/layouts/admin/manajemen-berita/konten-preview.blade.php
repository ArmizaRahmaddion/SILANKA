@extends('layouts.dashboard-layouts', ['title' => 'Preview Konten'])

@section('content-dashboard')
    <div class="row">
        <div class="col-12">
            {{-- Action Bar --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span
                                    class="badge bg-{{ $konten->status == 'published' ? 'success' : 'warning' }} px-3 py-2">
                                    @if ($konten->status == 'published')
                                        <i class="ri-global-line me-1"></i>Published
                                    @else
                                        <i class="ri-draft-line me-1"></i>Draft
                                    @endif
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Preview Konten</h6>
                                <small
                                    class="text-muted">{{ $konten->kategoriKoten->nama_kategori ?? 'Tanpa Kategori' }}</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('konten.edit', $konten) }}" class="btn btn-outline-warning btn-sm">
                                <i class="ri-edit-2-line me-2"></i>Edit
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="ri-more-2-line me-2"></i>Lainnya
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('konten.updateStatus', $konten) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status"
                                                value="{{ $konten->status == 'published' ? 'draft' : 'published' }}">
                                            <button type="submit" class="dropdown-item">
                                                @if ($konten->status == 'published')
                                                    <i class="ri-draft-line me-2"></i>Ubah ke Draft
                                                @else
                                                    <i class="ri-global-line me-2"></i>Publish
                                                @endif
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="ri-delete-bin-2-line me-2"></i>Hapus Konten
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="ri-arrow-left-line me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content Preview --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- Featured Image --}}
                    @if ($konten->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $konten->image) }}" alt="{{ $konten->title }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Content Header --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                @if ($konten->kategoriKoten)
                                    <span class="badge bg-primary bg-opacity-10 text-white px-3 py-2 mb-2">
                                        <i class="ri-bookmark-line me-1"></i>{{ $konten->kategoriKoten->nama_kategori }}
                                    </span>
                                @endif
                                <h1 class="display-6 fw-bold text-dark mb-3">{{ $konten->title }}</h1>
                            </div>
                        </div>

                        {{-- Meta Information --}}
                        <div class="d-flex flex-wrap align-items-center text-muted mb-4">
                            <div class="me-4 mb-2">
                                <i class="ri-user-line me-2"></i>
                                <span>{{ $konten->author ?? 'Admin' }}</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="ri-calendar-line me-2"></i>
                                <span>{{ $konten->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if ($konten->created_at != $konten->updated_at)
                                <div class="me-4 mb-2">
                                    <i class="ri-edit-line me-2"></i>
                                    <span>Diperbarui {{ $konten->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            @endif
                            <div class="mb-2">
                                <i class="ri-code-line me-2"></i>
                                <code class="bg-light px-2 py-1 rounded">{{ $konten->slug }}</code>
                            </div>
                        </div>

                        <hr class="my-4">
                    </div>

                    {{-- Content Body --}}
                    <div class="content-body">
                        <div class="ql-editor" style="padding: 0;">
                            {!! $konten->body !!}
                        </div>
                    </div>

                    {{-- Content Footer --}}
                    <div class="mt-5 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Informasi Konten</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">KATEGORI</label>
                                            <div>{{ $konten->kategoriKoten->nama_kategori ?? 'Tanpa Kategori' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">STATUS</label>
                                            <div>
                                                <span
                                                    class="badge bg-{{ $konten->status == 'published' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($konten->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">PENULIS</label>
                                            <div>{{ $konten->author ?? 'Admin' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">SLUG</label>
                                            <div><code class="bg-light px-2 py-1 rounded">{{ $konten->slug }}</code></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Statistik</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">DIBUAT</label>
                                            <div>{{ $konten->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $konten->created_at->format('H:i') }} WIB</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">DIPERBARUI</label>
                                            <div>{{ $konten->updated_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $konten->updated_at->format('H:i') }} WIB</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">JUMLAH KARAKTER</label>
                                            <div>{{ number_format(strlen(strip_tags($konten->body))) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-muted">ESTIMASI BACA</label>
                                            <div>{{ ceil(str_word_count(strip_tags($konten->body)) / 200) }} menit</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">
                        <i class="ri-delete-bin-2-line me-2"></i>Hapus Konten
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="ri-error-warning-line display-4 text-warning"></i>
                    </div>
                    <h5 class="mb-3">Apakah Anda yakin?</h5>
                    <p class="text-muted mb-3">
                        Konten "<strong>{{ $konten->title }}</strong>" akan dihapus secara permanen.
                    </p>
                    <div class="alert alert-warning">
                        <i class="ri-information-line me-2"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-2"></i>Batal
                    </button>
                    <form action="{{ route('konten.destroy', $konten) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ri-delete-bin-2-line me-2"></i>Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Quill Editor Styles for Content Display --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            border-radius: 12px;
        }

        .content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .content-body h1,
        .content-body h2,
        .content-body h3,
        .content-body h4,
        .content-body h5,
        .content-body h6 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .content-body p {
            margin-bottom: 1.5rem;
        }

        .content-body blockquote {
            border-left: 4px solid #0d6efd;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #6c757d;
        }

        .content-body ul,
        .content-body ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .content-body li {
            margin-bottom: 0.5rem;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .content-body code {
            background-color: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.9em;
        }

        .content-body pre {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
            overflow-x: auto;
        }

        .modal-content {
            border-radius: 12px;
        }

        /* Print styles */
        @media print {

            .card:first-child,
            .modal,
            .btn,
            .dropdown {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print functionality (optional)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
            });
        });
    </script>
@endpush
