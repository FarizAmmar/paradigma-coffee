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

    {{-- Menu Listing --}}
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
                                        <b>Menus</b>
                                    </div>
                                    <div class="col-12">
                                        <span class="text-secondary">A list of all menu for your customer here.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn-outline-dark btn btn-sm" id="btn-new-cat" type="button"
                                    data-bs-toggle="modal" data-bs-target="#new-form-menu">New
                                    Menu</button>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Option</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($menus->count() > 0)
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td>
                                            <button class="btn btn-light btn-sm mx-1" type="button" data-bs-toggle="modal"
                                                data-bs-target="#edit-form-menu{{ $menu->id }}">
                                                <i class='bx bxs-pencil'></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm mx-1" type="button" data-bs-toggle="modal"
                                                data-bs-target="#modal_delete_menu{{ $menu->id }}">
                                                <i class='bx bxs-trash-alt'></i>
                                            </button>
                                        </td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->description }}</td>
                                        <td>Rp.{{ $menu->amount }}</td>
                                        <td>{{ $menu->category->code . ' - ' . $menu->category->description }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
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

    {{-- New Modal Entries --}}
    <div class="modal" tabindex="-1" id="new-form-menu">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Entries</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu.menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label text-end">Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control @error('new-name')
                                    is-invalid
                                @enderror"
                                    name="new-name" style="width: 30vh;" value="{{ old('new-name') }}">
                                @error('new-name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label text-end">Upload Image</label>
                            <div class="col-sm-8">
                                <input type="file"
                                    class="form-control @error('new-image')
                                is-invalid
                            @enderror"
                                    name="new-image">
                                @error('new-image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label text-end">Category</label>
                            <div class="col-sm-8">
                                <select
                                    class="form-control @error('new-category')
                                is-invalid
                            @enderror"
                                    name="new-category">
                                    <option value="" selected hidden>Choose category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->code }}">{{ $cat->code . ' - ' . $cat->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('new-category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label text-end">Price</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text"
                                        class="form-control @error('new-amount')
                                        is-invalid
                                    @enderror"
                                        name="new-amount" value="{{ old('new-amount') }}">
                                    @error('new-amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label text-end">Description</label>
                            <div class="col-sm-8">
                                <textarea
                                    class="form-control @error('new-desc')
                                    is-invalid
                                @enderror"
                                    name="new-desc" cols="15" rows="3">{{ old('new-desc') }}</textarea>
                                @error('new-desc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-dark btn-sm" name="btn-new">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal Entries --}}
    @foreach ($menus as $menu)
        <div class="modal" tabindex="-1" id="edit-form-menu{{ $menu->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Entries</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center mb-4">
                            <div class="col-6">
                                <img class="img-thumbnail shadow"
                                    src="{{ asset('storage/uploads/' . $menu->image_path) }}" alt="Menu Image">
                            </div>
                        </div>

                        <form action="{{ route('menu.menus.update', ['id' => $menu->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Name</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control @error('edit-name')
                                    is-invalid
                                @enderror"
                                        name="edit-name" style="width: 30vh;"
                                        value="{{ old('edit-name') ? old('edit-name') : $menu->name }}">
                                    @error('edit-name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Upload Image</label>
                                <div class="col-sm-8">
                                    <input type="file"
                                        class="form-control @error('edit-image')
                                is-invalid
                            @enderror"
                                        name="edit-image">
                                    @error('edit-image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Category</label>
                                <div class="col-sm-8">
                                    <select
                                        class="form-control @error('edit-category')
                                is-invalid
                            @enderror"
                                        name="edit-category">
                                        <option value="{{ $menu->category_code }}" selected hidden>
                                            {{ $menu->category_code . ' - ' . $menu->category->description }}</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->code }}">
                                                {{ $cat->code . ' - ' . $cat->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('edit-category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Price</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="text"
                                            class="form-control @error('edit-amount')
                                        is-invalid
                                    @enderror"
                                            name="edit-amount"
                                            value="{{ old('edit-amount') ? old('edit-amount') : $menu->amount }}">
                                        @error('edit-amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Description</label>
                                <div class="col-sm-8">
                                    <textarea
                                        class="form-control @error('edit-desc')
                                    is-invalid
                                @enderror"
                                        name="edit-desc" cols="15" rows="3">{{ old('edit-desc') ? old('edit-desc') : $menu->description }}</textarea>
                                    @error('edit-desc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-dark btn-sm" name="btn-edit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Delet Modal --}}
    @foreach ($menus as $menu)
        <div class="modal" tabindex="-1" id="modal_delete_menu{{ $menu->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this menu? <b>{{ $menu->name }}</b> </p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('menu.menus.delete', ['id' => $menu->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark btn-sm">Delete</button>
                        </form>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@if (session('ShowNewEntriesMenu'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('new-form-menu'));
            modal.show();
        });
    </script>
@endif

@if (session('ShowEditEntriesMenu'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editData = @json(session('editData'));
            if (editData) {
                var modal = new bootstrap.Modal(document.getElementById('edit-form-menu' + editData.id));
                modal.show();
            }
        });
    </script>
@endif
