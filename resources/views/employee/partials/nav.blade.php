<!-- Home Navigation -->
@if ($title == 'Home')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link {{ $errors->any() ? 'text-secondary' : 'active' }}" type="button"
                id="btn-listing">Employee
                Listing</button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $errors->any() ? 'active' : 'text-secondary' }}" type="button" id="btn-new">New
                Entries</button>
        </li>
    </ul>
@elseif($title == 'Category')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link {{ $errors->any() ? 'text-secondary' : 'active' }}" type="button">Category</button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $errors->any() ? 'active' : 'text-secondary' }}" type="button">Menu</button>
        </li>
    </ul>
@endif
