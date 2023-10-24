@extends('employee.layouts.master')

@section('container')
    <form action="{{ route('report.search') }}" method="POST">
        @csrf
        <div class="bg-light text-dark container mt-3 rounded p-2 shadow">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2 text-end">
                                    <label for="from-date" class="col-form-label">From Date :</label>
                                </div>
                                <div class="col-3 d-flex">
                                    <input type="date" class="form-control form-control-sm" id="from-date"
                                        name="from_date"
                                        value="{{ session('FromDate') != null ? session('FromDate') : '' }}">
                                </div>
                                <div class="col-2 text-end">
                                    <label for="to-date" class="col-form-label">To Date :</label>
                                </div>
                                <div class="col-3 d-flex">
                                    <input type="date" class="form-control form-control-sm" id="to-date" name="to_date"
                                        value="{{ session('Todate') != null ? session('Todate') : '' }}">
                                </div>
                                <div class="col-2 d-flex">
                                    <button class="btn btn-light btn-sm shadow" style="width: 15vh;">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="card mt-3 rounded" style="border: none">
        <div class="card-body shadow">

            <table class="table-striped table" id="{{ $reports != null ? 'myTables' : '' }}">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Total Price</th>
                        <th>Sold Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($reports != null)
                        @foreach ($reports as $item)
                            <tr>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->menu->amount * $item->total_order_qty }}</td>
                                <td>{{ $item->total_order_qty }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="3">
                                No item
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if (session('FromDate') != null && session('ToDate') != null)
    <script>
        $(document).ready(function() {
            // Dapatkan tanggal hari ini
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            // Atur nilai default pada elemen input tanggal "To Date" ke hari ini
            $('#to-date').val(today);

            // Hitung tanggal 7 hari sebelum "To Date"
            var sevenDaysAgo = new Date(today);
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
            var dd7 = String(sevenDaysAgo.getDate()).padStart(2, '0');
            var mm7 = String(sevenDaysAgo.getMonth() + 1).padStart(2, '0');
            var yyyy7 = sevenDaysAgo.getFullYear();
            sevenDaysAgo = yyyy7 + '-' + mm7 + '-' + dd7;

            // Atur nilai default pada elemen input tanggal "From Date" ke 7 hari sebelum "To Date"
            $('#from-date').val(sevenDaysAgo);
        });
    </script>
@endif
