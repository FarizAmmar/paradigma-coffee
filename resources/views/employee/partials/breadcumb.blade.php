@if ($title == 'Home')
    @if (auth()->user()->access == 'EMP')
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('emp.home') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Listing</li>
                <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">Dashboard</li>
            </ol>
        </nav>
    @else
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('emp.home') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Listing</li>
                <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">Employee</li>
                <li class="d-none breadcrumb-item" aria-current="page" id="new-breadcrumb">New</li>
            </ol>
        </nav>
    @endif
@elseif ($title == 'Category' || $title == 'Menu')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('menu.cat') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Listing</li>
            <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">
                {{ $title == 'Category' || $title == 'Menu' ? $title : '' }}</li>
        </ol>
    </nav>
@elseif ($title == 'Waiting List' || $title == 'Orders')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('order.waiting') }}">Orders</a></li>
            <li class="breadcrumb-item" aria-current="page">Listing</li>
            <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">
                {{ $title == 'Waiting List' || $title == 'Orders' ? $title : '' }}</li>
        </ol>
    </nav>
@elseif ($title == 'Report')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('report') }}">Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Listing</li>
        </ol>
    </nav>
@endif
