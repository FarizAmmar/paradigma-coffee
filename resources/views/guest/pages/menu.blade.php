@extends('guest.layouts.master_guest')

@section('container')
    <div class="container-fluid">
        <div class="row">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <a class="text-decoration-none text-dark" href="#">
                        <div class="card shadow" style="border: none;" id="menu-card">
                            <img src="{{ asset('assets/images/menu/Iced Americano.webp') }}" class="card-img-top"
                                alt="Americano">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">Americano {{ $i + 1 }}</h5>
                                <p class="card-text text-truncate">Lorem ipsum dolor sit amet.</p>
                                <p class="card-text">Rp.20.000</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
        </div>
    </div>
@endsection
