@extends('layouts.dashboard-layouts', ['title' => 'Edit Konten'])

@section('content-dashboard')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0 text-dark fw-bold">
                                <i class="ri-edit-2-line me-2 text-warning"></i>Edit Konten
                            </h4>
                            <p class="text-muted mb-0 small">Perbarui artikel atau berita yang sudah ada</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('konten.show', $konten) }}" class="btn btn-outline-info btn-sm">
                                <i class="ri-eye-line me-2"></i>Preview
                            </a>
                            <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary">
                                <i class="ri-arrow-left-line me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('konten.update', $konten) }}" method="POST" enctype="multipart/form-data"
                        id="formKonten">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-lg-8">
                                {{-- Title --}}
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-semibold">
                                        Judul Konten <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" value="{{ old('title', $konten->title) }}"
                                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                                        id="title" placeholder="Masukkan judul konten yang menarik..."
                                        autocomplete="off">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-1">
                                        Slug saat ini: <code>{{ $konten->slug }}</code>
                                    </small>
                                </div>

                                {{-- Content Body --}}
                                <div class="mb-4">
                                    <label for="body" class="form-label fw-semibold">
                                        Isi Konten <span class="text-danger">*</span>
                                    </label>
                                    <div id="quill-editor" style="height: 400px;"></div>
                                    <textarea name="body" id="body" class="d-none @error('body') is-invalid @enderror">{{ old('body', $konten->body) }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-2 d-block">
                                        <i class="ri-information-line me-1"></i>
                                        Gunakan editor di atas untuk memformat konten Anda dengan rich text
                                    </small>
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-lg-4">
                                {{-- Publishing Options --}}
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-header bg-transparent border-0 pb-2">
                                        <h6 class="card-title mb-0 fw-semibold">
                                            <i class="ri-settings-3-line me-2"></i>Pengaturan Publikasi
                                        </h6>
                                    </div>
                                    <div class="card-body pt-0">
                                        {{-- Status --}}
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-semibold">
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <select name="status" id="status"
                                                class="form-select @error('status') is-invalid @enderror">
                                                <option value="draft"
                                                    {{ old('status', $konten->status) == 'draft' ? 'selected' : '' }}>
                                                    📝 Draft
                                                </option>
                                                <option value="published"
                                                    {{ old('status', $konten->status) == 'published' ? 'selected' : '' }}>
                                                    🌐 Published
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Category --}}
                                        <div class="mb-3">
                                            <label for="kategori_koten_id" class="form-label fw-semibold">
                                                Kategori <span class="text-danger">*</span>
                                            </label>
                                            <select name="kategori_koten_id" id="kategori_koten_id"
                                                class="form-select @error('kategori_koten_id') is-invalid @enderror">
                                                <option value="">Pilih Kategori...</option>
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ old('kategori_koten_id', $konten->kategori_koten_id) == $kategori->id ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kategori_koten_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Author --}}
                                        <div class="mb-3">
                                            <label for="author" class="form-label fw-semibold">Penulis</label>
                                            <input type="text" name="author"
                                                value="{{ old('author', $konten->author) }}"
                                                class="form-control @error('author') is-invalid @enderror" id="author"
                                                placeholder="Nama penulis...">
                                            @error('author')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Kosongkan untuk menggunakan nama Anda</small>
                                        </div>

                                        {{-- Meta Info --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Informasi</label>
                                            <div class="small text-muted">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Dibuat:</span>
                                                    <span>{{ $konten->created_at->format('d M Y, H:i') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Diperbarui:</span>
                                                    <span>{{ $konten->updated_at->format('d M Y, H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Featured Image --}}
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-header bg-transparent border-0 pb-2">
                                        <h6 class="card-title mb-0 fw-semibold">
                                            <i class="ri-image-line me-2"></i>Gambar Unggulan
                                        </h6>
                                    </div>
                                    <div class="card-body pt-0">
                                        {{-- Current Image --}}
                                        @if ($konten->image)
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Gambar Saat Ini</label>
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $konten->image) }}" alt="Current Image"
                                                        class="img-fluid rounded border" style="max-height: 200px;"
                                                        id="current-image">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                                        id="remove-current-image" title="Hapus gambar saat ini">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- New Image Upload --}}
                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-semibold">
                                                {{ $konten->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                                            </label>
                                            <input type="file" name="image" id="image"
                                                class="form-control @error('image') is-invalid @enderror"
                                                accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted mt-2 d-block">
                                                Format: JPEG, PNG, JPG, GIF, WebP (Max: 2MB)
                                            </small>
                                        </div>

                                        {{-- New Image Preview --}}
                                        <div id="image-preview" class="mt-3 d-none">
                                            <label class="form-label fw-semibold">Preview Gambar Baru</label>
                                            <img id="preview-img" src="" class="img-fluid rounded border"
                                                style="max-height: 200px;">
                                            <button type="button" id="remove-image"
                                                class="btn btn-sm btn-outline-danger mt-2 w-100">
                                                <i class="ri-delete-bin-line me-1"></i>Hapus Preview
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" value="save" class="btn btn-warning btn-lg">
                                        <i class="ri-save-line me-2"></i>Update Konten
                                    </button>
                                    <button type="submit" name="action" value="save_and_preview"
                                        class="btn btn-outline-primary">
                                        <i class="ri-eye-line me-2"></i>Update & Preview
                                    </button>
                                    <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary">
                                        <i class="ri-close-line me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Quill Editor Styles --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            border-radius: 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        #quill-editor {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        #quill-editor:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .ql-toolbar {
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }

        .ql-container {
            border-bottom-left-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    {{-- Quill Editor Scripts --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill Editor
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Mulai menulis konten Anda di sini...',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        [{
                            'font': []
                        }],
                        [{
                            'size': ['small', false, 'large', 'huge']
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'align': []
                        }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Set initial content
            const bodyContent = document.getElementById('body').value;
            if (bodyContent) {
                quill.root.innerHTML = bodyContent;
            }

            // Update hidden textarea when form is submitted
            document.getElementById('formKonten').addEventListener('submit', function() {
                document.getElementById('body').value = quill.root.innerHTML;
            });

            // Image preview functionality
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const removeImageBtn = document.getElementById('remove-image');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.classList.add('d-none');
                previewImg.src = '';
            });

            // Remove current image functionality
            const removeCurrentImageBtn = document.getElementById('remove-current-image');
            if (removeCurrentImageBtn) {
                removeCurrentImageBtn.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus gambar saat ini?')) {
                        document.getElementById('current-image').style.display = 'none';
                        this.style.display = 'none';

                        // Add hidden input to indicate image removal
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'remove_image';
                        hiddenInput.value = '1';
                        document.getElementById('formKonten').appendChild(hiddenInput);
                    }
                });
            }

            // Form validation enhancements
            const form = document.getElementById('formKonten');
            form.addEventListener('submit', function(e) {
                // Check if Quill editor has content
                const content = quill.getText().trim();
                if (content.length === 0) {
                    e.preventDefault();
                    alert('Konten tidak boleh kosong!');
                    quill.focus();
                    return false;
                }

                // Show loading state
                const submitBtns = form.querySelectorAll('button[type="submit"]');
                submitBtns.forEach(btn => {
                    btn.disabled = true;
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="ri-loader-4-line me-2 spin"></i>Memperbarui...';

                    // Re-enable after some time (fallback)
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }, 10000);
                });
            });
        });
    </script>
@endpush
