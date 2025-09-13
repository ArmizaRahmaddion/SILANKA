@extends('layouts.landing-page.layout')
@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-10">
                            <h1>{{ $konten->title }}</h1>
                            <div class="meta-info d-flex flex-wrap justify-content-center align-items-center gap-4 mt-3">
                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                    {{ $konten->kategoriKoten->nama_kategori }}
                                </span>
                                <div class="text-muted d-flex align-items-center">
                                    <i class="bi bi-person-fill me-2"></i>
                                    <strong>{{ $konten->author }}</strong>
                                </div>
                                <div class="text-muted d-flex align-items-center">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    {{ $konten->created_at->format('d F Y') }}
                                </div>
                                <div class="text-muted d-flex align-items-center">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ $konten->created_at->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('berita') }}">Berita Nagari</a></li>
                        <li class="current">{{ Str::limit($konten->title, 50) }}</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Blog Details Section -->
        <section id="blog-details" class="blog-details section">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <article class="article">

                            <!-- Featured Image -->
                            @if ($konten->image)
                                <div class="post-img mb-4">
                                    <img src="{{ asset('storage/' . $konten->image) }}" alt="{{ $konten->title }}"
                                        class="img-fluid rounded shadow-sm w-100"
                                        style="max-height: 500px; object-fit: cover;">
                                </div>
                            @endif

                            <!-- Article Header -->
                            <div class="article-header mb-4 pb-4 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="author-info d-flex align-items-center">
                                            <div class="author-avatar me-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="bi bi-person-fill text-white fs-5"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $konten->author }}</h6>
                                                <p class="text-muted mb-0 small">
                                                    Dipublikasikan {{ $konten->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                        <!-- Social Share Buttons -->
                                        <div class="share-buttons">
                                            <span class="text-muted small me-2">Bagikan:</span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                target="_blank" class="btn btn-outline-primary btn-sm me-1"
                                                title="Share to Facebook">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($konten->title) }}"
                                                target="_blank" class="btn btn-outline-info btn-sm me-1"
                                                title="Share to Twitter">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                            <a href="https://wa.me/?text={{ urlencode($konten->title . ' - ' . url()->current()) }}"
                                                target="_blank" class="btn btn-outline-success btn-sm"
                                                title="Share to WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Article Content -->
                            <div class="content">
                                <div class="article-body" style="line-height: 1.8; font-size: 1.1rem;">
                                    {!! $konten->body !!}
                                </div>
                            </div>

                            <!-- Article Footer -->
                            <div class="article-footer mt-5 pt-4 border-top">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="tags">
                                            <span class="text-muted me-2">Kategori:</span>
                                            <a href="{{ route('berita', ['kategori' => $konten->kategoriKoten->slug]) }}"
                                                class="badge bg-primary text-decoration-none">
                                                {{ $konten->kategoriKoten->nama_kategori }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <a href="{{ route('berita') }}" class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Berita
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="sidebar">

                            <!-- Recent Posts Widget -->
                            @if ($relatedKontents->count() > 0)
                                <div class="sidebar-item recent-posts">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="card-title mb-0">
                                                <i class="bi bi-newspaper me-2"></i>Berita Terkait
                                            </h4>
                                        </div>
                                        <div class="card-body p-0">
                                            @foreach ($relatedKontents as $related)
                                                <div class="post-item p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                    <div class="d-flex">
                                                        @if ($related->image)
                                                            <div class="me-3 flex-shrink-0">
                                                                <img src="{{ asset('storage/' . $related->image) }}"
                                                                    alt="{{ $related->title }}" class="rounded"
                                                                    style="width: 80px; height: 60px; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            <div class="me-3 flex-shrink-0 bg-light rounded d-flex align-items-center justify-content-center"
                                                                style="width: 80px; height: 60px;">
                                                                <i class="bi bi-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-fill">
                                                            <h6 class="mb-1">
                                                                <a href="{{ route('berita.detail', $related->slug) }}"
                                                                    class="text-decoration-none text-dark fw-semibold"
                                                                    style="font-size: 0.9rem; line-height: 1.3;">
                                                                    {{ Str::limit($related->title, 60) }}
                                                                </a>
                                                            </h6>
                                                            <div class="text-muted small d-flex align-items-center">
                                                                <i class="bi bi-calendar3 me-1"></i>
                                                                {{ $related->created_at->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Categories Widget -->
                            <div class="sidebar-item categories mt-4">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-secondary text-white">
                                        <h4 class="card-title mb-0">
                                            <i class="bi bi-folder me-2"></i>Kategori Berita
                                        </h4>
                                    </div>
                                    <div class="card-body p-0">
                                        @php
                                            $categories = \App\Models\KategoriKoten::withCount([
                                                'kontens' => function ($query) {
                                                    $query->where('status', 'published');
                                                },
                                            ])
                                                ->orderBy('nama_kategori')
                                                ->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                            <div class="category-item p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('berita', ['kategori' => $category->slug]) }}"
                                                        class="text-decoration-none fw-semibold
                                                              {{ $konten->kategori_koten_id == $category->id ? 'text-primary' : 'text-dark' }}">
                                                        {{ $category->nama_kategori }}
                                                    </a>
                                                    <span class="badge bg-light text-dark">
                                                        {{ $category->kontens_count }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Links Widget -->
                            <div class="sidebar-item mt-4">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-success text-white">
                                        <h4 class="card-title mb-0">
                                            <i class="bi bi-link-45deg me-2"></i>Layanan Cepat
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('e-surat') }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-envelope-paper me-2"></i>E-Surat
                                            </a>
                                            <a href="{{ url('e-aduan') }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-chat-dots me-2"></i>E-Aduan
                                            </a>
                                            <a href="{{ url('chek-surat') }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-search me-2"></i>Cek Status Surat
                                            </a>
                                            <a href="{{ url('perangkat') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-people me-2"></i>Perangkat Nagari
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section><!-- /Blog Details Section -->

        <!-- Custom Styles -->
        <style>
            .article-body h1,
            .article-body h2,
            .article-body h3,
            .article-body h4,
            .article-body h5,
            .article-body h6 {
                color: #2c3e50;
                margin-top: 2rem;
                margin-bottom: 1rem;
            }

            .article-body h2 {
                font-size: 1.75rem;
                border-bottom: 2px solid var(--bs-primary);
                padding-bottom: 0.5rem;
            }

            .article-body h3 {
                font-size: 1.5rem;
                color: var(--bs-primary);
            }

            .article-body p {
                margin-bottom: 1rem;
                text-align: justify;
            }

            .article-body ul,
            .article-body ol {
                margin-bottom: 1.5rem;
                padding-left: 2rem;
            }

            .article-body li {
                margin-bottom: 0.5rem;
            }

            .article-body blockquote {
                background-color: #f8f9fa;
                border-left: 4px solid var(--bs-primary);
                padding: 1rem 1.5rem;
                margin: 2rem 0;
                font-style: italic;
                border-radius: 0 0.25rem 0.25rem 0;
            }

            .article-body table {
                width: 100%;
                margin-bottom: 2rem;
                border-collapse: collapse;
            }

            .article-body table th,
            .article-body table td {
                padding: 0.75rem;
                border: 1px solid #dee2e6;
                text-align: left;
            }

            .article-body table th {
                background-color: #f8f9fa;
                font-weight: 600;
            }

            .article-body img {
                max-width: 100%;
                height: auto;
                border-radius: 0.25rem;
                margin: 1rem 0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .share-buttons a:hover {
                transform: translateY(-2px);
                transition: all 0.3s ease;
            }

            .sidebar .card {
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .sidebar .card-header {
                border-bottom: none;
                font-weight: 600;
            }

            .sidebar .post-item:hover {
                background-color: #f8f9fa;
                transition: background-color 0.3s ease;
            }

            .sidebar .category-item:hover {
                background-color: #f8f9fa;
                transition: background-color 0.3s ease;
            }

            .sidebar .category-item a:hover {
                color: var(--bs-primary) !important;
            }

            @media (max-width: 768px) {
                .meta-info {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }

                .article-body {
                    font-size: 1rem !important;
                }

                .share-buttons {
                    text-align: center;
                }
            }
        </style>

    </main>
@endsection
