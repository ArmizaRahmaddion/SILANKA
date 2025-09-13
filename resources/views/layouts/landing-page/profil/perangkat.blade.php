@extends('layouts.landing-page.layout')
@section('content')
    <main class="main">
        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>PERANGKAT DESA</h1>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="#">Beranda</a></li>
                        <li class="current">Perangkat Desa</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Team Section -->
        <section id="perangkat" class="team section">

            <div class="container">
                @if ($perangkat->isEmpty())
                    <div class="py-5 text-center">
                        <h5 class="text-muted mb-0">Data perangkat belum tersedia.</h5>
                    </div>
                @else
                    <div class="row g-4 justify-content-center">
                        @foreach ($perangkat as $data)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex" data-aos="fade-up"
                                data-aos-delay="{{ $loop->iteration * 70 }}">
                                <div class="card shadow-sm border-0 rounded-4 w-100 h-100 overflow-hidden posisi-relative">
                                    <div class="ratio ratio-1x1 bg-light">
                                        @if ($data->image && Storage::exists($data->image))
                                            <img src="{{ asset('storage/' . $data->image) }}" alt="Foto {{ $data->nama }}"
                                                class="w-100 h-100 object-fit-cover" loading="lazy">
                                        @else
                                            <div class="d-flex w-100 h-100 align-items-center justify-content-center text-muted small"
                                                style="background-color: #e9ecef;">
                                                <span class="d-flex flex-column justify-content-center align-items-center">
                                                    <i class="bi bi-image" style="font-size: 3rem"></i>
                                                    <span class="text-muted fs-5 fw-semibold">Belum Ada Foto</span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex flex-column text-center p-3">
                                        <h6 class="mb-1 fw-semibold text-dark">{{ $data->nama }}</h6>
                                        <p class="text-muted small mb-3">{{ $data->jabatan }}</p>

                                        @php
                                            $telepon = $data->telepon ?? ($data->phone ?? ($data->no_hp ?? null));
                                            $whatsapp = $data->whatsapp ?? ($data->wa ?? null);
                                            $email = $data->email ?? null;
                                        @endphp

                                        @if ($data->facebook || $data->instagram || $telepon || $whatsapp || $email)
                                            <div class="mt-auto pt-2">
                                                <div class="d-flex flex-wrap justify-content-center gap-2">

                                                    @if ($data->facebook)
                                                        <a href="{{ $data->facebook }}" target="_blank" rel="noopener"
                                                            class="badge rounded-pill bg-primary text-white text-decoration-none d-inline-flex align-items-center gap-1"
                                                            aria-label="Facebook {{ $data->nama }}">
                                                            <i class="bi bi-facebook"></i><span>Facebook</span>
                                                        </a>
                                                    @endif

                                                    @if ($data->instagram)
                                                        <a href="{{ $data->instagram }}" target="_blank" rel="noopener"
                                                            class="badge rounded-pill bg-danger text-white text-decoration-none d-inline-flex align-items-center gap-1"
                                                            aria-label="Instagram {{ $data->nama }}">
                                                            <i class="bi bi-instagram"></i><span>Instagram</span>
                                                        </a>
                                                    @endif

                                                    @if ($whatsapp)
                                                        @php
                                                            $waNum = preg_replace('/\D+/', '', $whatsapp);
                                                            if (Str::startsWith($waNum, '0')) {
                                                                $waNum = '62' . substr($waNum, 1);
                                                            }
                                                        @endphp
                                                        <a href="https://wa.me/{{ $waNum }}" target="_blank"
                                                            rel="noopener"
                                                            class="badge rounded-pill bg-success text-white text-decoration-none d-inline-flex align-items-center gap-1"
                                                            aria-label="WhatsApp {{ $data->nama }}">
                                                            <i class="bi bi-whatsapp"></i><span>WhatsApp</span>
                                                        </a>
                                                    @endif

                                                    @if ($telepon)
                                                        <a href="tel:{{ preg_replace('/\D+/', '', $telepon) }}"
                                                            class="badge rounded-pill bg-secondary text-decoration-none d-inline-flex align-items-center gap-1"
                                                            aria-label="Telepon {{ $data->nama }}">
                                                            <i class="bi bi-telephone"></i><span>{{ $telepon }}</span>
                                                        </a>
                                                    @endif

                                                    @if ($email)
                                                        <a href="mailto:{{ $email }}"
                                                            class="badge rounded-pill bg-dark text-white text-decoration-none d-inline-flex align-items-center gap-1"
                                                            aria-label="Email {{ $data->nama }}">
                                                            <i class="bi bi-envelope"></i><span>Email</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="position-absolute top-0 start-0 w-100 h-100 card-hover-overlay"
                                        style="pointer-events:none;opacity:0;transition:.35s;background:linear-gradient(to top,rgba(0,0,0,.45),rgba(0,0,0,0));">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <style>
                .card:hover .card-hover-overlay {
                    opacity: 1;
                }

                .object-fit-cover {
                    object-fit: cover;
                }
            </style>

        </section><!-- /Team Section -->


    </main>
@endsection
