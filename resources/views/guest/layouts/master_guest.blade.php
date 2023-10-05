<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradigma Coffee | {{ $title }}</title>

    {{-- Bootsstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Boxicons Icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
    {{-- Navbar --}}
    <div class="container mt-3">
        @include('guest.partials.navbar')
    </div>

    {{-- Main and Sidebar --}}
    <div class="container mb-5 mt-5">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-12 col-md-8">
                @yield('container')
            </div>
            {{-- Sidebar --}}
            @if ($title != 'Checkout')
                <div class="col-4 d-none d-md-block d-lg-block">
                    @include('guest.partials.sidebar')
                </div>
            @endif
        </div>
    </div>

    {{-- Footer Desktop --}}
    <footer class="fixed-bottom navbar navbar-expand-lg navbar-dark bg-dark d-none d-md-block">
        <div class="container-fluid">
            <div class="text-light mx-auto">
                Paradigma Coffee &copy; Copyright 2023
            </div>
            <div class="text-secondary mr-auto">
                <span>Version 1.0.0</span>
            </div>
        </div>
    </footer>

    {{-- Footer Mobile --}}
    <div class="container-fluid">
        @include('guest.partials.footer')
    </div>



    {{-- Bootstrap Javascript --}}
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- Custom Javascript --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
