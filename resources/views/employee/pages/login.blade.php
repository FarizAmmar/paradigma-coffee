@extends('employee.layouts.master')

@section('container')
    <div class="row">
        {{-- Form --}}
        <div class="col-12 col-md-5 cs-main-bg">
            <div class="container" style="height: 100vh;">
                <a href="{{ route('guest.menu') }}" class="btn cs-btn-primary mt-3 shadow-sm">
                    <i class='bx bx-chevron-left'></i>
                </a>
                <form action="{{ route('emp.login.auth') }}" method="POST" style="padding-top: 50px;">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 mt-3 text-center">
                            <h3 class="display-2 text-light text-uppercase text-shadow">Login</h3>
                            <p class="text-light" style="opacity: 60%;">
                                Paradigma Coffee Employee Login.
                            </p>
                        </div>

                        {{-- Alert --}}
                        @if (session('loginFailed'))
                            <div class="col-12 my-1">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('loginFailed') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        <div class="col-12 mt-1">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control cs-form-control @error('username')
                                is-invalid
                                @enderror shadow"
                                    value="{{ old('username') }}" id="username" name="username" placeholder="Username">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating">
                                <input type="password"
                                    class="form-control cs-form-control @error('password')
                                is-invalid
                                @enderror shadow"
                                    id="password" name="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-lg cs-btn-color1 shadow" style="width: 130px;"
                                type="submit">LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Background --}}
        <div class="col-7 cs-background d-none d-md-block"></div>
    </div>

    <div class="container-fluid">
        <footer class="navbar navbar-expand-lg navbar-dark bg-trans fixed-bottom cs-wave"></footer>
    </div>
@endsection
