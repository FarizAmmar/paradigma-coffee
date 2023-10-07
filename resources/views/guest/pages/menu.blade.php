@extends('guest.layouts.master_guest')

@section('container')
    <div class="container-fluid">
        <div class="row">
            @foreach ($menus as $menu)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <a class="text-decoration-none text-dark" role="button">
                        <div class="card shadow" style="border: none;" id="menu-card">
                            <img src="{{ asset('storage/uploads/' . $menu->image_path) }}" class="card-img-top img-thumbnail"
                                alt="Americano" style="border: none;">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $menu->name }}</h5>
                                <p class="card-text text-truncate">{{ $menu->description }}</p>
                                <p class="card-text">Rp.{{ $menu->amount }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
