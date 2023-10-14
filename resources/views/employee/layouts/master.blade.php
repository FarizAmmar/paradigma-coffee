<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradigma Coffee | {{ $title }}</title>

    {{-- Bootsstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Boxicons Icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/employee/css/style.css') }}">
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- Bootstrap Javascript --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    {{-- Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
    {{-- Login Container --}}
    @if ($title == 'Login')
        <div class="container-fluid">
            @yield('container')
        </div>
    @endif

    {{-- Main Content Employee --}}
    @if ($title != 'Login')
        {{-- Navbar --}}
        <div class="container">
            @include('employee.partials.navbar')
        </div>

        {{-- Breadcumb --}}
        <div class="container mt-2 p-4">
            @include('employee.partials.breadcumb')
        </div>

        @if ($title == 'Home')
            <div class="container mb-3">
                @include('employee.partials.indicator')
            </div>
        @endif

        <div class="container mb-5">
            <div class="row">
                <div class="col-12">
                    {{-- Navigation --}}
                    @include('employee.partials.nav')
                    {{-- Main Content Page --}}
                    @yield('container')
                </div>
                @if ($title != 'Home')
                    <div class="col-12 col-md-5">
                        {{-- Sidebar --}}
                        @include('employee.partials.sidebar')
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Notification --}}
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="cartModalBody">
                    <!-- Konten modal akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>


    {{-- Javascript --}}
    {{-- Custom Javascript --}}
    <script src="{{ asset('assets/employee/js/script.js') }}"></script>
    {{-- Pusher script --}}
    <script>
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });

        var channel = pusher.subscribe('cart-channel');
        channel.bind('cart-event', function(data) {
            // Notification
            var modalBody = document.getElementById('cartModalBody');
            modalBody.innerHTML = data.message;
            $('#cartModal').modal('show');
            $("#no-record").hide();

            // Ambil data Menu berdasarkan menu_id
            var menuName = '';
            $.ajax({
                url: '/get-menu/' + data.order.menu_id, // Ganti dengan rute yang sesuai
                type: 'GET',
                success: function(response) {
                    menuName = response.name;
                },
                async: false // Pastikan ini synchronus untuk mendapatkan hasil sebelum menambahkannya ke tabel
            });

            var paymentText = ''; // Variabel untuk menyimpan teks pembayaran

            switch (data.order.payment) {
                case 'On_Table':
                    paymentText = 'On Table Payment';
                    break;

                case 'On_Cashier':
                    paymentText = 'On Cashier Payment';
                    break;

                default:
                    paymentText = ''; // Atau teks default lainnya jika diperlukan
                    break;
            }

            var newRow = `
            <tr>
                <td><input class="form-check-input" type="checkbox" value="${data.order.id}" id="select-item[]"></td>
                <td>${data.order.table_no}</td>
                <td>${menuName}</td>
                <td>${data.order.order_qty}</td>
                <td>${paymentText}</td>
            </tr>
        `;

            $("#table-orders").append(newRow);

        });

        // var channel = pusher.subscribe('cart-channel');
        // channel.bind('cart-event', function(data) {
        //     // // Data yang diterima dari event
        //     var menuData = data.cartItem;


        //     // Perbarui tampilan dengan data yang diterima
        //     document.getElementById('menu-image').src = menuData
        //         .image_path; // Gantilah 'image_url' dengan properti yang sesuai
        //     document.getElementById('menu-title').textContent = menuData.name;
        //     document.getElementById('menu-description').textContent = menuData.description;
        //     document.getElementById('menu-price').textContent = 'Rp. ' + menuData.amount;
        // });
    </script>
</body>

</html>
