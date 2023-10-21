@if ($title != 'Menus')
    <nav class="navbar navbar-expand-sm navbar-light bg-light mt-4 rounded shadow">
        <div class="container-fluid">

            {{-- Menu --}}
            <ul class="navbar-nav mb-lg-0 mb-2 me-auto">
                <div class="row">
                    <div class="col">
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Home' ? 'active' : '' }}" aria-current="page"
                                href="{{ route('emp.home') }}">Dashboard</a>
                        </li>
                    </div>
                    <div class="col">
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Menu' || $title == 'Category' ? 'active' : '' }}"
                                href="{{ route('menu.cat') }}">Menu</a>
                        </li>
                    </div>
                    <div class="col">
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Waiting List' ? 'active' : '' }}"
                                href="{{ route('order.waiting') }}">Order</a>
                        </li>
                    </div>
                    <div class="col">
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Report' ? 'active' : '' }}"
                                href="{{ route('report') }}">Report</a>
                        </li>
                    </div>
                </div>
            </ul>

            {{-- Exit --}}
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal-exit">
                <i class='bx bx-exit' style="font-size: 25px;"></i>
            </button>
        </div>
    </nav>
@endif


<div class="modal" tabindex="-1" id="modal-exit">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure want to logout?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('emp.logout') }}" method="GET">
                    <button type="submit" class="btn btn-dark btn-sm">Yes</button>
                </form>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
