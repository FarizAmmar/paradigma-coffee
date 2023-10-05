@extends('guest.layouts.master_guest')

@section('container')
    <div class="container-fluid">
        <div class="border-bottom container">
            {{-- Select All --}}
            <div class="row mb-2">
                <div class="col-6 d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="select-all">
                        <label class="form-check-label" for="select-all">
                            Select All
                        </label>
                    </div>
                </div>
                {{-- Delete Selected --}}
                <div class="col-6 text-end">
                    <a href="#" class="btn btn-light btn-sm">
                        <i class='bx bx-trash' style="font-size: 20px;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Content Items --}}
        @for ($i = 0; $i < 2; $i++)
            <div class="border-bottom container my-2">
                <div class="row mb-2">
                    <div class="col-1 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="select-items">
                        </div>
                    </div>
                    <div class="col-4 justify-content-center d-flex align-items-center">
                        <img src="{{ asset('assets/images/menu/Iced Americano.webp') }}" class="img-fluid rounded"
                            alt="americano">
                    </div>
                    <div class="col-7">
                        <h5 class="card-title">Americano</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6 d-flex align-items-center">
                        <h5>Rp.20.000</h5>
                    </div>
                    <div class="col-6 text-end">
                        <button class="cs-decrease shadow-sm">
                            <i class='bx bx-minus'></i>
                        </button>
                        <input class="cs-form-quantity border-bottom text-center" type="number" name=""
                            id="" value="1" min="1" max="99">
                        <button class="cs-increase shadow-sm">
                            <i class='bx bx-plus'></i>
                        </button>
                    </div>
                </div>
            </div>
        @endfor
    </div>
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
                        {{-- Payment Table --}}
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <form action="#" method="POST">
                                    <input class="form-control form-control-lg cs-table-number text-center"
                                        type="number" name="" id="" style="width: 70px;" autofocus>
                            </div>
                        </div>
                        <div class="col-12 mb-3 text-end">
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal-payment"
                                type="button">Next</button>
                        </div>
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
                            <a class="text-decoration-none text-dark" href="#" data-bs-dismiss="modal">
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
                            <a class="text-decoration-none text-dark" href="#" data-bs-dismiss="modal">
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
