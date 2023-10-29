<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title }} - Paradigma Coffee</title>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}">

</head>

<body>

    <div class="container mt-5 p-0">

        <div class="card rounded border-0 shadow">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="text-uppercase">
                            Paradigma Coffee
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td style="width: 100px;">
                                    From Date
                                </td>
                                <td style="width: 5px;">
                                    :
                                </td>
                                <td style="padding-left: 10px;">
                                    {{ $fromdate }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 100px;">
                                    To Date
                                </td>
                                <td style="width: 5px;">
                                    :
                                </td>
                                <td style="padding-left: 10px;">
                                    {{ $todate }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <table class="table-striped table-bordered mt-3 table">
                    <thead>
                        @php
                            $no = 1;
                            $totalIncome = 0;
                        @endphp
                        <tr>
                            <th style="width: 70px;">No</th>
                            <th>Menu Name</th>
                            <th>Order Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportData as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->total_order_qty }}</td>
                                @php
                                    $itemPrice = $item->menu->amount * $item->total_order_qty;
                                    $totalIncome += $itemPrice;
                                @endphp
                                <td>Rp. {{ $itemPrice }}</td>
                            </tr>
                        @endforeach
                        {{-- Total --}}
                        <tr>
                            <td colspan="3" style="text-align: end"> <b>Total Income :</b></td>
                            <td>Rp. {{ $totalIncome }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- Bootstrap Javscript --}}
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
