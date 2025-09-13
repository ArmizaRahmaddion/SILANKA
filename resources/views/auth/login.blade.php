@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <!-- Form Section - Left Side -->
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center mb-3">
                                        <!--Logo start-->
                                        <div class="logo-main">
                                            <img src="{{ asset('assets/images/LimaPuluhKotaLogo.png') }}" alt="Logo Normal"
                                                class="logo-normal img-fluid" style="max-height: 40px;">
                                            <img src="{{ asset('assets/images/LimaPuluhKotaLogo.png') }}" alt="Logo Mini"
                                                class="logo-mini img-fluid d-none">
                                        </div>

                                        <!--logo End-->
                                        <h4 class="logo-title ms-3">SILANKA</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center">Sistem Informasi Layanan Administrasi Koto Alam</p>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="nipOrnik" class="form-label">Email, NIP, atau NIK</label>
                                                    <input type="text" name="nipOrnik" value="{{ old('nipOrnik') }}"
                                                        class="form-control @error('nipOrnik') is-invalid @enderror"
                                                        id="nipOrnik" placeholder="Masukkan email atau NIP atau NIK"
                                                        required autofocus>
                                                    @error('nipOrnik')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password" placeholder="Masukkan password" required>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="remember"
                                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-info">Masuk ke akun</button>
                                        </div>
                                        <p class="mt-3 text-center">
                                            Belum punya akun? <a href="{{ route('register') }}" class="text-underline">Klik
                                                untuk daftar</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image Section - Right Side -->
                <!-- Hero Image Section - Right Side -->
                <div class="col-md-6 d-md-block d-none p-0 vh-100 overflow-hidden d-flex align-items-center justify-content-center"
                    style="background-color: #008374;">
                    <div class="text-center p-4">
                        <img src="{{ asset('assets/images/hero.png') }}" class="img-fluid"
                            alt="SILANKA - Sistem Informasi Layanan Administrasi"
                            style="max-height: 80vh; object-fit: contain;">
                        <div class="mt-3">
                            <h5 class="text-white">Sistem Informasi Layanan Administrasi</h5>
                            <h5 class="text-white ">Koto Alam</h5>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
