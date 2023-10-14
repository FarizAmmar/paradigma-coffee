@extends('guest.layouts.master_guest')

@section('container')
    <div class="container-fluid">
        <div class="row">
            @foreach ($menus as $menu)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <form action="{{ route('cart.store', ['menu_id' => $menu->id, 'uuid' => $uuid]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card shadow" style="border: none;" id="menu-card">
                            <img src="{{ asset('storage/uploads/' . $menu->image_path) }}" class="card-img-top img-thumbnail"
                                alt="Americano" style="border: none;">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $menu->name }}</h5>
                                <p class="card-text text-truncate">{{ $menu->description }}</p>
                                <p class="card-text">Rp.{{ $menu->amount }}</p>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-dark w-100" type="submit">Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach

        </div>
    </div>
@endsection
