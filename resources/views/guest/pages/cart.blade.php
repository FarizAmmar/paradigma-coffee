@extends('guest.layouts.master_guest')

@section('container')
    <form action="/order/checkout/store" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="border-bottom container">
                {{-- Select All --}}
                <div class="row mb-2">
                    <div class="col-6 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" onchange="SelectAllCart()" id="select-all">
                            <label class="form-check-label" for="select-all">
                                Select All
                            </label>
                        </div>
                    </div>
                    {{-- Delete Selected --}}
                    <div class="col-6 text-end">
                        <button class="btn btn-light btn-sm" name="delete-selected-items" type="submit">
                            <i class='bx bx-trash' style="font-size: 20px;"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Main Content Items --}}
            @foreach ($groupedCarts as $carts => $items)
                @php
                    $item = $items->first();
                @endphp
                <div class="border-bottom container my-2">
                    <div class="row mb-2">
                        <div class="col-1 d-flex align-items-center">
                            <div class="form-check">
                                <input type="hidden" name="user_id" value="{{ $uuid }}">
                                <input type="hidden" name="menu_id[]" value="{{ $item->menu_id }}"
                                    data-menu-id="{{ $item->menu_id }}">
                                <input type="hidden" name="menu_price[]" value="{{ $item->menu->amount }}"
                                    data-menu-price="{{ $item->menu->amount }}">
                                <input class="form-check-input" type="checkbox" name="select-item[]"
                                    value="{{ $item->menu->id }}">
                            </div>
                        </div>
                        <div class="col-4 justify-content-center d-flex align-items-center">
                            <img src="{{ asset('/storage/uploads/' . $item->menu->image_path) }}" class="img-fluid rounded">
                        </div>
                        <div class="col-7">
                            <h5 class="card-title">{{ $item->menu->name }}</h5>
                            <p class="card-text">{{ $item->menu->description }}</p>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-6 d-flex align-items-center">
                            <input type="hidden" name="normal-price[]" value="{{ $item->menu->amount }}">
                            <h5 class="total-price">Rp.{{ $item->menu->amount * $item->order_qty }}
                            </h5>
                        </div>
                        <div class="col-6 text-end">
                            <button class="cs-decrease shadow-sm" type="button" onclick="OnDecrease(this)">
                                <i class='bx bx-minus'></i>
                            </button>
                            <input class="cs-form-quantity order-qty border-bottom text-center" type="number"
                                name="quantityInput[]" value="{{ $item->order_qty }}" min="1" max="99">
                            <button class="cs-increase shadow-sm" type="button" onclick="OnIncrease(this)">
                                <i class='bx bx-plus'></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        @php
            $totalSubtotal = 0;
        @endphp
        @foreach ($groupedCarts as $carts => $items)
            @php
                $item = $items->first();
                $subtotal = $item->menu->amount * $item->order_qty;
                $totalSubtotal += $subtotal;
            @endphp
        @endforeach
        <footer class="fixed-bottom navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
            <div class="container-fluid d-flex align-items-center">
                <div class="ml-auto">
                    <h5 class="navbar-brand" id="sub-total">Rp.{{ $totalSubtotal }}</h5>
                </div>
                <div class="mr-auto">
                    <button class="btn btn-light" type="submit">
                        Checkout
                    </button>
                </div>
            </div>
        </footer>
    </form>
@endsection

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
