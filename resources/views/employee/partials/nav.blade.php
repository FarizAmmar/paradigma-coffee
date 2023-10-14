<!-- Home Navigation -->
@if ($title == 'Home')
    @if (auth()->user()->access != 'EMP')
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link {{ session('ShowNewEntries') ? 'text-secondary' : 'active' }}" type="button"
                    id="btn-listing">Employee
                    Listing</button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ session('ShowNewEntries') ? 'active' : 'text-secondary' }}" type="button"
                    id="btn-new">New
                    Entries</button>
            </li>
        </ul>
    @endif
@elseif($title == 'Category' || $title == 'Menu')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="{{ route('menu.cat') }}" class="nav-link {{ $title == 'Category' ? 'active' : 'text-secondary' }}"
                type="button">Category</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('menu.menus') }}"
                class="nav-link {{ $title == 'Menu' ? 'active' : 'text-secondary' }}">Menu</a>
        </li>
    </ul>
@elseif($title == 'Waiting List')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="{{ route('order.waiting') }}"
                class="nav-link {{ $title == 'Waiting List' ? 'active' : 'text-secondary' }}" type="button">Waiting
                List</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ $title == 'Menu' ? 'active' : 'text-secondary' }}">Order</a>
        </li>
    </ul>
@endif
