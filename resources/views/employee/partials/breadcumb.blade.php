@if ($title == 'Home')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emp.home') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Listing</li>
            <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">Employee</li>
            <li class="d-none breadcrumb-item" aria-current="page" id="new-breadcrumb">New</li>
        </ol>
    </nav>
@elseif ($title == 'Category')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('menu.cat') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Listing</li>
            <li class="breadcrumb-item active" aria-current="page" id="view-breadcrumb">Category</li>
        </ol>
    </nav>
@endif
