@extends('layouts.landing-page.layout')
@section('content')
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section accent-background">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-5 justify-content-between">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">

                        <h2><span>Selamat Datang di </span><span class="accent">SILANKA</span></h2>
                        <p>Sistem Informasi Layanan Administrasi Nagari Koto Alam</p>
                        <p>menghadirkan solusi efektifitas pelayanan masyarakat dengan dukungan teknologi terpadu dan
                            mudah digunakan.</p>
                        <div class="d-flex">
                            <a href="#faq" class="btn-get-started">Panduan</a>
                            {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2">
                        <img src="{{ asset('assets/images/Hero.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>

            <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
                <div class="container position-relative">
                    <div class="row gy-4 mt-5">

                        <div class="col-xl-6 col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bi bi-envelope-paper"></i></div>
                                <h4 class="title"><a href="{{ url('e-surat') }}" class="stretched-link">Layanan E-Surat</a>
                                </h4>
                            </div>
                        </div><!--End Icon Box -->

                        <div class="col-xl-6 col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bi bi-mailbox"></i></div>
                                <h4 class="title"><a href="{{ url('e-aduan') }}" class="stretched-link">Layanan
                                        E-Aduan</a>
                                </h4>
                            </div>
                        </div><!--End Icon Box -->

                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <section>
                <div class="container section-title" data-aos="fade-up">
                    <h2>TENTANG SILANKA<br></h2>
                </div><!-- End Section Title -->

                <div class="container">
                    <div class="row align-items-center gy-4">
                        <!-- Kolom Gambar -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                            <img src="{{ URL::asset('assets/images/About.png') }}" class="img-fluid rounded-4"
                                alt="">
                        </div>

                        <!-- Kolom Teks -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                            <h3>Pelayanan Administrasi Nagari Lebih Mudah Dan Cepat</h3>
                            <p style="text-align: justify;">
                                SILANKA (Sistem Informasi Layanan Administrasi Nagari Koto Alam) merupakan sistem
                                pelayanan administrasi kependudukan berbasis website untuk mengelola proses pelayanan
                                administrasi
                                pembuatan surat-menyurat, layanan pengaduan online, seputar informasi nagari, yang
                                bertujuan untuk
                                mempermudah proses administratif, mempercepat pelayanan masyarakat di nagari, sarana
                                publikasi informasi nagari,
                                serta sebagai bentuk sinkronisasi antara program pemerintah provinsi yakni menghadirkan
                                layanan secara Cepat,
                                Efektif, Efisien, Tanggap, Transparan.
                            </p>
                        </div>

                    </div>
                </div>
            </section>
            <!-- /About Section -->


            <!-- Stats Section -->
            <section id="stats" class="stats section">

                <div class="container" data-aos="fade-up" data-aos-delay="100">

                    <div class="row gy-4 align-items-center">

                        <div class="col-lg-5">
                            <img src="{{ URL::asset('assets/images/LimaPuluhKotaLogo.png') }}" alt=""
                                class="img-fluid w-50">
                        </div>

                        <div class="col-lg-7">

                            <div class="row gy-4">

                                <div class="col-lg-6">
                                    <div class="stats-item d-flex">
                                        <i class="bi bi-people flex-shrink-0"></i>
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="232"
                                                data-purecounter-duration="1" class="purecounter"></span>
                                            <p><strong>Pengguna Layanan</strong> </p>
                                        </div>
                                    </div>
                                </div><!-- End Stats Item -->

                                <div class="col-lg-6">
                                    <div class="stats-item d-flex">
                                        <i class="bi bi-journal-richtext flex-shrink-0"></i>
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="521"
                                                data-purecounter-duration="1" class="purecounter"></span>
                                            <p><strong>Dokumen Dibuat</strong> </p>
                                        </div>
                                    </div>
                                </div><!-- End Stats Item -->

                            </div>

                        </div>

                    </div>

                </div>

            </section><!-- /Stats Section -->

            <!-- Faq Section -->
            <section id="faq" class="faq section">

                <div class="container">

                    <div class="row gy-4">

                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="content px-xl-5">
                                <h3><span>Panduan Penggunaan </span><strong>SILANKA</strong></h3>
                                {{-- <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                            </p> --}}
                            </div>
                        </div>

                        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                            <div class="faq-container">
                                <div class="faq-item faq-active">
                                    <h3><span class="num"></span> <span>PENDAFTARAN</span></h3>
                                    <div class="faq-content">
                                        <p>1.<span></span> Klik tombol <strong> "Daftar"</strong> jika belum mempunyai
                                            akun</p>
                                        <p>2.<span></span> Lengkapi formulir pendaftaran lalu tekan
                                            <strong>"Daftar"</strong>
                                        </p>
                                        <p>3.<span></span> Menunggu verikasi oleh <strong> Admin </strong> </p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3><span class="num"></span> <span>PENGAJUAN SURAT</span></h3>
                                    <div class="faq-content">
                                        <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                            interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                            scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper
                                            dignissim.
                                            Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3><span class="num"></span> <span>PENGADUAN</span></h3>
                                    <div class="faq-content">
                                        <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                            Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet
                                            nisl
                                            suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis
                                            convallis
                                            convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi
                                            quis
                                        </p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->



                            </div>

                        </div>
                    </div>

                </div>

            </section><!-- /Faq Section -->

            <!-- Recent Posts Section -->
            {{-- <section id="recent-posts" class="recent-posts section">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>BERITA NAGARI</h2>
                    <p>Berita Seputar Nagari Koto Alam</p>
                </div><!-- End Section Title -->

                <div class="container">

                    <div class="row gy-4">

                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <article>

                                <div class="post-img">
                                    <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                                </div>

                                <p class="post-category">Politics</p>

                                <h2 class="title">
                                    <a href="blog-details.html">Dolorum optio tempore voluptas dignissimos</a>
                                </h2>

                                <div class="d-flex align-items-center">
                                    <img src="assets/img/blog/blog-author.jpg" alt=""
                                        class="img-fluid post-author-img flex-shrink-0">
                                    <div class="post-meta">
                                        <p class="post-author">Maria Doe</p>
                                        <p class="post-date">
                                            <time datetime="2022-01-01">Jan 1, 2022</time>
                                        </p>
                                    </div>
                                </div>

                            </article>
                        </div><!-- End post list item -->

                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <article>

                                <div class="post-img">
                                    <img src="assets/img/blog/blog-2.jpg" alt="" class="img-fluid">
                                </div>

                                <p class="post-category">Sports</p>

                                <h2 class="title">
                                    <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
                                </h2>

                                <div class="d-flex align-items-center">
                                    <img src="assets/img/blog/blog-author-2.jpg" alt=""
                                        class="img-fluid post-author-img flex-shrink-0">
                                    <div class="post-meta">
                                        <p class="post-author">Allisa Mayer</p>
                                        <p class="post-date">
                                            <time datetime="2022-01-01">Jun 5, 2022</time>
                                        </p>
                                    </div>
                                </div>

                            </article>
                        </div><!-- End post list item -->

                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <article>

                                <div class="post-img">
                                    <img src="assets/img/blog/blog-3.jpg" alt="" class="img-fluid">
                                </div>

                                <p class="post-category">Entertainment</p>

                                <h2 class="title">
                                    <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et
                                        soluta</a>
                                </h2>

                                <div class="d-flex align-items-center">
                                    <img src="assets/img/blog/blog-author-3.jpg" alt=""
                                        class="img-fluid post-author-img flex-shrink-0">
                                    <div class="post-meta">
                                        <p class="post-author">Mark Dower</p>
                                        <p class="post-date">
                                            <time datetime="2022-01-01">Jun 22, 2022</time>
                                        </p>
                                    </div>
                                </div>

                            </article>
                        </div><!-- End post list item -->

                    </div><!-- End recent posts list -->

                </div>

            </section><!-- /Recent Posts Section --> --}}

            {{--  --}}

    </main>
@endsection
