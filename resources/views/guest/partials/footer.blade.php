@if ($title == 'Menus')
    <footer class="fixed-bottom navbar navbar-expand-lg navbar-light bg-trans d-md-none"
        style="height: 60px; backdrop-filter: blur(10px);">
        <div class="mx-auto">
            <a href="{{ route('guest.cart') }}"
                class="text-decoration-none rounded-circle bg-light d-flex justify-content-center position-relative"
                style="width: 100px; height: 100px;">
                @php
                    $count = count($carts);
                @endphp
                @if ($count > 0)
                    <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger top-0">
                        {{ $count }}
                    </span>
                @endif
                <i class='bx bx-cart text-dark mt-3' style="font-size: 30px;"></i>
            </a>
        </div>
    </footer>

@endif
