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
        @if ($title == 'Menus')
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
            <form action="{{ route('guest.menu') }}" method="get">
                @php
                    $default = request('filter') == null ? 'btn-dark' : 'btn-outline-dark';
                @endphp
                <button class="btn {{ $default }} btn-sm mx-1 my-2" type="submit">All</button>
                @foreach ($categories as $cat)
                    @php
                        $btnClass = $cat->code == request('filter') ? 'btn-dark' : 'btn-outline-dark';
                    @endphp
                    <button class="btn {{ $btnClass }} btn-sm mx-1 my-2" name="filter" value="{{ $cat->code }}"
                        type="submit">
                        {{ $cat->description }}
                    </button>
                @endforeach
            </form>
        </div>
    </div>
</div>

@if (session('OpenCollapse') != false)
    <script>
        $(document).ready(function() {
            $('#filtering').collapse('show');
        });
    </script>
@endif
