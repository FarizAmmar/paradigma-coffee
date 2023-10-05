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
    <link rel="stylesheet" href="{{ asset('assets/employee/css/style.css') }}">


</head>

<body>
    {{-- Login Container --}}
    @if ($title == 'Login')
        <div class="container-fluid">
            @yield('container')
        </div>
    @endif

    {{-- Main Content --}}
    @if ($title != 'Login')
        {{-- Navbar --}}
        <div class="container">
            @include('employee.partials.navbar')
        </div>

        {{-- Breadcumb --}}
        <div class="container mt-2 p-4">
            @include('employee.partials.breadcumb')
        </div>

        <div class="container mb-5">
            <div class="row">
                <div class="col-12">
                    {{-- Navigation --}}
                    @include('employee.partials.nav')
                    {{-- Main Content Page --}}
                    @yield('container')
                </div>
                @if ($title != 'Home')
                    <div class="col-12 col-md-5">
                        {{-- Sidebar --}}
                        @include('employee.partials.sidebar')
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Javascript --}}

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- Bootstrap Javascript --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    {{-- Custom Javascript --}}
    <script src="{{ asset('assets/employee/js/script.js') }}"></script>
</body>

</html>
