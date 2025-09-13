@extends('layouts.app', ['title' => 'Register'])

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
                                    <h2 class="mb-2 text-center">Register</h2>
                                    <p class="text-center">Sistem Informasi Layanan Administrasi Koto Alam</p>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus
                                                placeholder="Masukkan nama lengkap">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email"
                                                placeholder="Masukkan alamat email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="new-password" placeholder="Masukkan password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password-confirm"
                                                class="form-label">{{ __('Confirm Password') }}</label>
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password"
                                                placeholder="Konfirmasi password">
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-info">
                                                {{ __('Register') }}
                                            </button>
                                        </div>

                                        <p class="mt-3 text-center">
                                            Sudah punya akun? <a href="{{ route('login') }}" class="text-underline">Klik
                                                untuk masuk</a>
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
