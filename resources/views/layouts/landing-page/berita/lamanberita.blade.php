@extends('layouts.landing-page.layout')
@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>BERITA NAGARI KOTO ALAM</h1>
                            <p class="mb-0">Informasi terkini seputar kegiatan, pengumuman, dan perkembangan terbaru di
                                Nagari Koto Alam.
                                Tetap terhubung dengan berbagai informasi penting untuk kemajuan nagari kita bersama.</p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/beranda') }}">Beranda</a></li>
                        <li class="current">Berita Nagari</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Filter and Search Section -->
        <section class="filter-section py-4" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="GET" action="{{ route('berita') }}"
                            class="d-flex flex-wrap gap-3 align-items-center">
                            <!-- Category Filter -->
                            <div class="filter-group">
                                <label class="form-label fw-semibold mb-1">Kategori:</label>
                                <select name="kategori" class="form-select" style="min-width: 150px;">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}"
                                            {{ request('kategori') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Search Input -->
                            <div class="filter-group flex-fill">
                                <label class="form-label fw-semibold mb-1">Pencarian:</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari berita..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                </div>
                            </div>

                            <!-- Reset Filter -->
                            @if (request('kategori') || request('search'))
                                <div class="filter-group">
                                    <a href="{{ route('berita') }}" class="btn btn-outline-secondary mt-4">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Posts Section -->
        <section id="blog-posts" class="blog-posts section">
            <div class="container">
                @if ($kontents->count() > 0)
                    <!-- Results Info -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-muted mb-0">
                                    Menampilkan {{ $kontents->firstItem() }}-{{ $kontents->lastItem() }}
                                    dari {{ $kontents->total() }} berita
                                    @if (request('kategori'))
                                        dalam kategori
                                        <strong>{{ $categories->firstWhere('slug', request('kategori'))->nama_kategori ?? 'Kategori' }}</strong>
                                    @endif
                                    @if (request('search'))
                                        dengan kata kunci <strong>"{{ request('search') }}"</strong>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-4">
                        @foreach ($kontents as $konten)
                            <div class="col-lg-4 col-md-6">
                                <article class="h-100 shadow-sm border-0 rounded overflow-hidden"
                                    style="transition: all 0.3s ease; background: white;">

                                    <!-- Post Image -->
                                    <div class="post-img position-relative" style="height: 250px; overflow: hidden;">
                                        @if ($konten->image)
                                            <img src="{{ asset('storage/' . $konten->image) }}" alt="{{ $konten->title }}"
                                                class="img-fluid w-100 h-100"
                                                style="object-fit: cover; transition: transform 0.3s ease;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                <div class="text-center text-muted">
                                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                                    <p class="mb-0 mt-2">No Image</p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Category Badge -->
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                                {{ $konten->kategoriKoten->nama_kategori }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="p-4 d-flex flex-column flex-fill">
                                        <h3 class="title mb-3" style="font-size: 1.25rem; line-height: 1.4;">
                                            <a href="{{ route('berita.detail', $konten->slug) }}"
                                                class="text-decoration-none text-dark fw-semibold"
                                                style="transition: color 0.3s ease;">
                                                {{ Str::limit($konten->title, 80) }}
                                            </a>
                                        </h3>

                                        <!-- Excerpt -->
                                        <div class="excerpt text-muted mb-3 flex-fill" style="font-size: 0.95rem;">
                                            {{ Str::limit(strip_tags($konten->body), 120) }}
                                        </div>

                                        <!-- Meta Info -->
                                        <div
                                            class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                                            <div class="author-info d-flex align-items-center">
                                                <div class="author-avatar me-2">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-person-fill text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="author-details">
                                                    <p class="post-author mb-0 fw-semibold" style="font-size: 0.85rem;">
                                                        {{ $konten->author }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="post-date text-muted" style="font-size: 0.8rem;">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <time datetime="{{ $konten->created_at->format('Y-m-d') }}">
                                                    {{ $konten->created_at->format('d M Y') }}
                                                </time>
                                            </div>
                                        </div>

                                        <!-- Read More Button -->
                                        <div class="mt-3">
                                            <a href="{{ route('berita.detail', $konten->slug) }}"
                                                class="btn btn-outline-primary btn-sm w-100"
                                                style="transition: all 0.3s ease;">
                                                <i class="bi bi-arrow-right me-1"></i> Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <!-- Custom Pagination -->
                    @if ($kontents->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <nav aria-label="Page navigation">
                                    <div class="d-flex justify-content-center">
                                        {{ $kontents->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </nav>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-newspaper" style="font-size: 4rem; color: #6c757d;"></i>
                                </div>
                                <h4 class="text-muted">Tidak Ada Berita Ditemukan</h4>
                                <p class="text-muted mb-4">
                                    @if (request('search'))
                                        Tidak ditemukan berita dengan kata kunci <strong>"{{ request('search') }}"</strong>
                                    @elseif(request('kategori'))
                                        Tidak ditemukan berita dalam kategori
                                        <strong>{{ $categories->firstWhere('slug', request('kategori'))->nama_kategori ?? 'Kategori' }}</strong>
                                    @else
                                        Belum ada berita yang dipublikasikan.
                                    @endif
                                </p>
                                @if (request('search') || request('kategori'))
                                    <a href="{{ route('berita') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-left me-2"></i>Lihat Semua Berita
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section><!-- /Blog Posts Section -->

        <!-- Additional Styles -->
        <style>
            .blog-posts article:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .blog-posts article:hover .post-img img {
                transform: scale(1.05);
            }

            .blog-posts article:hover .title a {
                color: var(--bs-primary) !important;
            }

            .filter-section .form-select:focus,
            .filter-section .form-control:focus {
                border-color: var(--bs-primary);
                box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
            }

            .pagination .page-link {
                color: var(--bs-primary);
                border-color: #dee2e6;
            }

            .pagination .page-item.active .page-link {
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
            }

            .pagination .page-link:hover {
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
                color: white;
            }
        </style>

    </main>
@endsection
