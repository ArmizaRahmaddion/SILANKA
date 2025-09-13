<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SILANKA E - Surat | {{ $title ?? 'Page Title' }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/LimaPuluhKotaLogo.png') }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/core/libs.min.css" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/hope-ui.min.css?v=2.0.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/custom.min.css?v=2.0.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/dark.min.css" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/customizer.min.css" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/rtl.min.css" />

    <!-- Remixicon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>

    @stack('styles')
</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">

    @yield('content')

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets') }}/js/core/libs.min.js"></script>
    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets') }}/js/core/external.min.js"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets') }}/js/charts/widgetcharts.js"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets') }}/js/charts/vectore-chart.js"></script>
    <script src="{{ asset('assets') }}/js/charts/dashboard.js"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets') }}/js/plugins/fslightbox.js"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets') }}/js/plugins/setting.js"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets') }}/js/plugins/slider-tabs.js"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets') }}/js/plugins/form-wizard.js"></script>

    <!-- AOS Animation Plugin-->
    <script src="{{ asset('assets') }}/vendor/aos/dist/aos.js"></script>

    <!-- App Script -->
    <script src="{{ asset('assets') }}/js/hope-ui.js" defer></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
    @stack('scripts')
    @stack('script-confeti')
    <script>
        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        function runConfetti() {
            if (typeof confetti === "function") {
                confetti({
                    angle: randomInRange(55, 125),
                    spread: randomInRange(50, 70),
                    particleCount: randomInRange(50, 100),
                    origin: {
                        y: 0.6
                    }
                });
            } else {
                alert('Confetti library is not loaded.');
            }
        }
    </script>
</body>

</html>
