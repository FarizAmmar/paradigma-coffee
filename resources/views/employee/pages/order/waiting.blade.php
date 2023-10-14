@extends('employee.layouts.master')

@section('container')
    {{-- Notification Error Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Order Listing --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card rounded shadow" style="border: none;">
                <div class="card-body">
                    {{-- Caption Header --}}
                    <div class="container mb-3 mt-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Waiting List</b>
                                    </div>
                                    <div class="col-12">
                                        <span class="text-secondary">A list of all waiting order for your employee
                                            here.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn-outline-dark btn btn-sm" id="btn-new-cat" type="button"
                                    data-bs-toggle="modal" data-bs-target="#new-form-menu">Accept</button>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input class="form-check-input" type="checkbox" id="select-all" onchange="SelectAll()">
                                    <!-- Tambahkan id="select-all" di sini -->
                                </th>
                                <th scope="col">Table Number</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Payment Method</th>
                            </tr>
                        </thead>
                        <tbody id="table-orders">
                            @if ($orders->count() > 0)
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $order->id }}"name="select-item[]">
                                        </td>
                                        <td>{{ $order->table_no }}</td>
                                        <td>{{ $order->menu->name }}</td>
                                        <td>{{ $order->order_qty }}</td>
                                        <td>
                                            @switch($order->payment)
                                                @case('On_Table')
                                                    On Table Payment
                                                @break

                                                @case('On_Cashier')
                                                    On Cashier Payment
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="no-record">
                                    <td class="text-center" colspan="5">
                                        There is no record for this menus
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function SelectAll() {
        var selectAllCheckbox = document.getElementById('select-all');
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = selectAllCheckbox.checked;
        }
    }
</script>
