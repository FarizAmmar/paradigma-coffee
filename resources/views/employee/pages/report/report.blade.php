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
                                        name="from_date" value="{{ $fromdate }}">
                                </div>
                                <div class="col-2 text-end">
                                    <label for="to-date" class="col-form-label">To Date :</label>
                                </div>
                                <div class="col-3 d-flex">
                                    <input type="date" class="form-control form-control-sm" id="to-date" name="to_date"
                                        value="{{ $todate }}">
                                </div>
                                <div class="col-1 d-flex">
                                    <button class="btn btn-light btn-sm shadow" style="width: 15vh;"
                                        name="btn-filter">Filter</button>
                                </div>
                                <div class="col-1 d-flex">
                                    <button class="btn btn-light btn-sm shadow" style="width: 15vh;"
                                        name="btn-print">Print</button>
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
<script>
    $(document).ready(function() {
        // Mendapatkan tanggal hari ini dalam format 'YYYY-MM-DD'
        var today = new Date().toISOString().split('T')[0];

        // Setel atribut 'max' pada elemen input date
        $("#from-date").attr("max", today);
        $("#to-date").attr("max", today);
    });
</script>
