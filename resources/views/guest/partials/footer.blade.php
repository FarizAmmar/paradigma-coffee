@if ($title == 'Menus')
    <footer class="fixed-bottom navbar navbar-expand-lg navbar-light bg-trans d-md-none"
        style="height: 60px; backdrop-filter: blur(10px);">
        <div class="mx-auto">
            <a href="{{ route('guest.cart') }}"
                class="text-decoration-none rounded-circle bg-light d-flex justify-content-center"
                style="width: 100px; height: 100px;">
                <i class='bx bx-cart text-dark mt-3' style="font-size: 30px;"></i>
            </a>
        </div>
    </footer>
@elseif ($title == 'Checkout')
    <footer class="fixed-bottom navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
        <div class="container-fluid d-flex align-items-center">
            <div class="ml-auto">
                <h5 class="navbar-brand">Rp.39.000</h5>
            </div>
            <div class="mr-auto">
                <a href="#modal-table-no" class="btn btn-light" data-bs-toggle="modal" type="button">
                    Checkout
                </a>
            </div>
        </div>
    </footer>
@endif
