<div class="container-fluid">
    <form action="{{ route('guest.cart.store') }}" method="POST">
        @csrf
        @method('POST')
        {{-- Cart --}}
        <div class="card mb-4 rounded shadow" style="border: none;">
            <div class="card-header" style="border: none;">
                Your Cart
            </div>
            <div class="card-body overflow-auto" style="max-height: 450px;">
                <div class="border-bottom container">
                    {{-- Select All --}}
                    <div class="row mb-2">
                        <div class="col-12 col-lg-6 col-sm-6 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onchange="SelectAllCart()"
                                    id="select-all">
                                <label class="form-check-label" for="select-all">
                                    Select All
                                </label>
                            </div>
                        </div>
                        {{-- Delete Selected --}}
                        <div class="col-12 col-lg-6 col-sm-6 text-end">
                            <button class="btn btn-light btn-sm" name="delete-selected-items" type="submit">
                                <i class='bx bx-trash' style="font-size: 20px;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Main Content Items --}}
                @if ($groupedCarts->count() > 0)
                    @foreach ($groupedCarts as $menuId => $carts)
                        @php
                            $firstCart = $carts->first();
                        @endphp
                        <div class="border-bottom container my-2" id="cart-container">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h5 class="card-title" id="menu-title">{{ $firstCart->menu->name }}</h5>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-1 d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="hidden" name="user_id" value="{{ $uuid }}">
                                        <input type="hidden" name="menu_id[]" value="{{ $firstCart->menu_id }}">
                                        <input class="form-check-input" type="checkbox" name="select-item[]"
                                            value="{{ $firstCart->menu->id }}">
                                    </div>
                                </div>
                                <div
                                    class="col-12 col-lg-3 col-md-10 justify-content-center d-flex align-items-center mb-2">
                                    <img src="{{ asset('/storage/uploads/' . $firstCart->menu->image_path) }}"
                                        class="img-fluid rounded" alt="" id="menu-image">
                                </div>
                                <div class="col-12 col-lg-8 col-md-12">
                                    <p class="card-text" id="menu-description">{{ $firstCart->menu->description }}</p>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 d-flex align-items-center pt-1">
                                    <h5 id="menu-price">Rp.{{ $firstCart->menu->amount * count($carts) }}</h5>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 text-end">
                                    {{-- Quantity --}}
                                    <input class="form-control text-center" type="number" name="quantityInput[]"
                                        value="{{ count($carts) }}" min="1" max="99">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="container my-5 text-center">
                        <p>Keranjang Anda kosong.</p>
                    </div>
                @endif

            </div>
        </div>


        {{-- Checkout --}}
        @php
            $totalSubtotal = 0;
            // $discount = 5000;
            // $tax = 3000;
        @endphp

        @foreach ($groupedCarts as $menuId => $carts)
            @php
                $firstCart = $carts->first();
                $subtotal = $firstCart->menu->amount * count($carts);
                $totalSubtotal += $subtotal;
            @endphp
        @endforeach

        <div class="card rounded shadow" style="border:none;">
            <div class="card-header" style="border: none;">
                Checkout
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">Your cart subtotal</div>
                    <div class="col-1">:</div>
                    <div class="col text-end">Rp.{{ $totalSubtotal }}</div>
                </div>
                {{-- <div class="row">
                    <div class="col">Discount</div>
                    <div class="col-1">:</div>
                    <div class="col text-end">Rp.{{ $discount }}</div>
                </div>
                <div class="row">
                    <div class="col">Tax</div>
                    <div class="col-1">:</div>
                    <div class="col text-end">Rp.{{ $tax }}</div>
                </div> --}}
            </div>
            <div class="card-footer" style="border: none;">
                <div class="row">
                    <div class="col">Rp.{{ $totalSubtotal }}</div>
                    <div class="col text-end">
                        {{-- data-bs-toggle="modal"
                            data-bs-target="#modal-table-no" --}}
                        <button class="btn btn-dark btn-sm" type="submit">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Table Number --}}
<div class="modal fade" tabindex="-1" id="modal-table-no">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        {{-- Payment Table --}}
                        <div class="col-12 mb-3 text-center">
                            <h4>Choose Table Number</h4>
                        </div>
                        <form action="{{ route('guest.cart.table') }}" method="POST">
                            @csrf
                            @method('POST')
                            {{-- Payment Table --}}
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="uuid" value="{{ $uuid }}">
                                    <input class="form-control form-control-lg cs-table-number text-center"
                                        type="text" name="table_no" id="table_no" style="width: 70px;" autofocus
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 3);">

                                </div>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-dark" type="submit">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Payment Option --}}
<div class="modal fade" tabindex="-1" id="modal-payment">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        {{-- Payment Table --}}
                        <div class="col-12 mb-3">
                            <a class="text-decoration-none text-dark"
                                href="{{ route('guest.cart.payment', ['uuid' => $uuid, 'payment' => 'On_Table']) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Payment On Table</h5>
                                        <h6 class="card-subtitle text-body-secondary mb-2">
                                            Pembayaran akan dilakukan di table oleh waiter.
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- Payment Table --}}
                        <div class="col-12 mb-3">
                            <a class="text-decoration-none text-dark"
                                href="{{ route('guest.cart.payment', ['uuid' => $uuid, 'payment' => 'On_Cashier']) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Payment On Cashier</h5>
                                        <h6 class="card-subtitle text-body-secondary mb-2">
                                            Pembayaran akan dilakukan di cashier.
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#inputNumber').on('input', function() {
            var inputValue = $(this).val();
            var numericValue = inputValue.replace(/[^0-9]/g, ''); // Hapus karakter non-angka
            var limitedValue = numericValue.slice(0, 3); // Ambil maksimal 3 karakter

            if (inputValue !== limitedValue) {
                $(this).val(limitedValue);
            }
        });
    });

    function SelectAllCart() {
        var selectAllCheckbox = document.getElementById("select-all");
        var selectItemCheckboxes = document.getElementsByName("select-item[]");

        // Periksa apakah "Select All" dicentang atau tidak
        var isChecked = selectAllCheckbox.checked;

        // Atur tindakan "Select All" pada semua elemen "select-item"
        for (var i = 0; i < selectItemCheckboxes.length; i++) {
            selectItemCheckboxes[i].checked = isChecked;
        }
    }
</script>


@if (session('ShowTableOrder'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('modal-table-no'));
            modal.show();
        });
    </script>
@elseif (session('ShowPayment'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('modal-payment'));
            modal.show();
        });
    </script>
@endif
