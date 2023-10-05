<nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow">
    <div class="container-fluid">
        {{-- Back Button for Cart --}}
        @if ($title == 'Checkout')
            <a href="{{ route('guest.menu') }}" class="btn btn-dark btn-sm">
                <i class='bx bx-chevron-left'></i>
            </a>
        @endif

        {{-- Branding --}}
        <a href="#" class="navbar-brand">{{ $brand ? $brand : '' }}</a>

        {{-- Filtering Menu --}}
        @if ($title == 'Menu')
            <div class="mr-auto">
                <a href="#filtering" class="btn btn-dark btn-sm" role="button" data-bs-toggle="collapse">
                    <i class='bx bx-filter'></i>
                </a>
            </div>
        @elseif ($title == 'Checkout')
            <div class="mr-auto">
                <i class='bx bx-cart' style="font-size: 30px;"></i>
            </div>
        @endif
    </div>
</nav>

{{-- Filtering Menu --}}
<div class="collapse" id="filtering">
    <div class="card card-body bg-light mt-2 rounded shadow" style="border: none;">
        <div class="container">
            <button class="btn btn-dark btn-sm mx-1 my-2">All</button>
            <button class="btn btn-outline-dark btn-sm mx-1 my-2">Coffee</button>
            <button class="btn btn-outline-dark btn-sm mx-1 my-2">Non Coffee</button>
            <button class="btn btn-outline-dark btn-sm mx-1 my-2">Snacks</button>
        </div>
    </div>
</div>
