@extends('guest.layouts.master_guest')

@section('container')
    <div class="d-flex align-items-center justify-content-center container" style="height: 100vh;">
        <div class="row w-100">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card rounded shadow" style="border: none;">
                    <div class="card-body">
                        @foreach ($groupedOrder as $items => $item)
                            @php
                                $inv = $item->first();
                            @endphp
                        @endforeach

                        {{-- Header --}}
                        <div class="row my-4">
                            <div class="col-12">
                                <h1 class="display-4" style="font-weight: 900;">
                                    <b>Invoice</b>
                                </h1>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Date :</b>
                                <br>
                                {{ $inv->created_at->format('l, d F Y') }}
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <b>Table No : </b> <span>#{{ $inv->table_no }}</span>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <div class="row overflow-auto">
                            <div class="col-12">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($groupedOrder as $items => $item)
                                            @php
                                                $order = $item->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-center">{{ $order->menu->name }}</td>
                                                <td class="text-center">{{ $order->order_qty }}</td>
                                                <td class="text-center">Rp.{{ $order->menu->amount * $order->order_qty }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="row mt-2">
                            <div class="col-12">
                                <b>Payment Menthod :</b>
                                <span>
                                    @switch($inv->payment)
                                        @case('On_Table')
                                            On Table Payment
                                        @break

                                        @case('On_Cashier')
                                            On Cashier Payment
                                        @break

                                        @default
                                            -
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <b>Status :</b>
                                <span>
                                    Unpaid
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
