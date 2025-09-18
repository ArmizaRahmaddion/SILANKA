<header id="header" class="header fixed-top">
    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:contact@example.com">kotoalam2005@gmail.com</a></i>
            </div>
            <div class="d-flex align-items-center ms-4 text-warning">
                <i class="bi bi-clock me-2"></i>
                <span><strong>Jadwal Pelayanan</strong>: Senin s.d Jum'at - 08.00 s.d 15.45 WIB</span>
            </div>

            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ URL::asset('assets/images/LimaPuluhKotaLogo.png') }}" alt="">
                <h3 class="sitename fw-bold">NAGARI KOTO ALAM</h3>
                <span>.</span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active">Beranda<br></a></li>
                    <li><a href="{{ url('perangkat') }}" class="active">Perangkat Nagari<br></a></li>

                    {{-- <li class="dropdown"><a href="#"><span>Profil</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Visi Misi</a></li>
                            <li><a href="{{ url('perangkat') }}">Perangkat Desa</a></li>
                        </ul>
                    </li> --}}
                    <li class="dropdown"><a href="#layanan"><span>Layanan Online</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ url('e-surat') }}">E-Surat</a></li>
                            <li><a href="{{ url('e-aduan') }}">E-Aduan</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('berita') }}">Berita Nagari</a></li>
                    <li class="dropdown"><a href="#Kontak"><span>Kontak</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Sekretaris Nagari</a></li>
                            <li><a href="#">Kepala Seksi Kesejahteraan</a></li>
                            <li><a href="#">Kepala Seksi Pelayanan</a></li>
                            <li><a href="#">Kepala Seksi Pemerintahan
                                </a></li>
                            <li><a href="#">Kepala Urusan Keuangan
                                </a></li>
                            <li><a href="#">Kepala Urusan Tata Usaha Dan Umum
                                </a></li>
                            <li><a href="#">Kepala Urusan Perencanaan
                                </a></li>
                            <li><a href="#">Kepala Jorong Koto Ranah
                                </a></li>
                            <li><a href="#">Kepala Jorong Simpang Tiga
                                </a></li>
                            <li><a href="#">Kepala Jorong Koto Tangah
                                </a></li>
                            <li><a href="#">Kepala Jorong Polong Duo
                                </a></li>
                            <li><a href="#">Staff Kaur Tata Usaha Dan Umum
                                </a></li>
                        </ul>
                    </li>

                    @auth
                        @php
                            $verifikasi = Auth::user()->verifikasi;
                            $namaLengkap =
                                $verifikasi && $verifikasi->status === 'verified' ? $verifikasi->nama_lengkap : 'Guest';
                        @endphp
                        <li class="dropdown">
                            <a href="#">
                                <span class="d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-person-circle" style="font-size: 1.2rem;" aria-hidden="true"></i>
                                    <span class="user-fullname">{{ $namaLengkap }}</span>
                                </span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('riwayat-surat.index') }}"><span><i
                                                class="bi bi-clock-history me-2"style="font-size: 1rem;"></i>
                                            Riwayat Surat
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('riwayat-pengaduan.index') }}"><span><i
                                                class="bi bi-clock-history me-2" style="font-size: 1rem;"></i>Riwayat
                                            Pengaduan</span>
                                    </a>
                                </li>
                                <li class="border-top mt-2 pt-2">
                                    <a href="#" class="text-danger"
                                        onclick="event.preventDefault(); document.getElementById('logout-masyarakat').submit();">
                                        <span><i class="bi bi-box-arrow-right me-2"
                                                style="font-size: 1rem;"></i>Logout</span>
                                    </a>
                                    <form method="POST" id="logout-masyarakat" action="{{ route('logout') }}"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @hasanyrole('superadmin|seknag')
                            <li><a href="{{ route('dashboard') }}" class="active">Back To Dashboard<br></a></li>
                        @endrole
                    @else
                        <li><a href="{{ url('register') }}"><strong>Daftar</strong></a></li>
                        <li><a href="{{ url('login') }}"><strong>Login</strong></a></li>
                    @endauth
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>
</header>
