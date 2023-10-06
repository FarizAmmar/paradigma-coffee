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

    <div class="row">
        {{-- Category Listing --}}
        <div class="col-12 col-md-6">
            <div class="card mb-3 mt-3 shadow" style="border: none; border-radius: 30px;" id="view-form-cat">
                <div class="card-body overflow-x-auto">

                    {{-- Caption Header --}}
                    <div class="container mb-3 mt-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Category</b>
                                    </div>
                                    <div class="col-12">
                                        <span class="text-secondary">A list of all menu category.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn-outline-dark btn btn-sm" id="btn-new-cat" type="button"
                                    data-bs-toggle="modal" data-bs-target="#new-form-cat">New
                                    Category</button>
                            </div>
                        </div>
                    </div>

                    {{-- Table Categories --}}
                    <table class="table">
                        <caption>{{ $categories->links() }}</caption>
                        <thead>
                            <tr>
                                <th scope="col" style="width: 150px;">
                                    Option
                                </th>
                                <th scope="col">Code</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $cat)
                                <tr>
                                    <td>
                                        <button class="btn btn-light btn-sm mx-1" type="button" data-bs-toggle="modal"
                                            data-bs-target="#edit-form-cat{{ $cat->code }}">
                                            <i class='bx bxs-pencil'></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm mx-1" type="button" data-bs-toggle="modal"
                                            data-bs-target="#modal_delete_cat{{ $cat->code }}">
                                            <i class='bx bxs-trash-alt'></i>
                                        </button>
                                    </td>
                                    <td>{{ $cat->code }}</td>
                                    <td>{{ $cat->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- New Form --}}
        <div class="modal" tabindex="-1" id="new-form-cat">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        {{-- Caption Header --}}
                        <div class="container mb-4 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <b>New Category</b>
                                </div>
                                <div class="col-12">
                                    <span class="text-secondary">This form field is mandatory, please fill carefully.</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- New Category --}}
                        <form action="{{ route('menu.cat.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Code</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control text-uppercase @error('new-code')
                                    is-invalid
                                @enderror"
                                        name="new-code" value="{{ old('new-code') }}" maxlength="3" style="width: 100px;">
                                    @error('new-code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Description</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control @error('new-desc')
                                is-invalid
                            @enderror"
                                        value="{{ old('new-desc') }}" name="new-desc">
                                    @error('new-desc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-dark btn-sm" name="btn-new"
                                        value="new">Save</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        @foreach ($categories as $cat)
            <div class="modal" tabindex="-1" id="edit-form-cat{{ $cat->code }}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            {{-- Caption Header --}}
                            <div class="container mb-4 mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <b>Edit Category</b>
                                    </div>
                                    <div class="col-12">
                                        <span class="text-secondary">This form field is mandatory, please fill
                                            carefully.</span>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            {{-- Edit Category --}}
                            <form action="{{ route('menu.cat.update', ['code' => $cat->code]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-end">Code</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control @error('edit-code')
                                    is-invalid
                                @enderror"
                                            name="edit-code"
                                            value="{{ old('edit-code') ? old('edit-code') : $cat->code }}"
                                            style="pointer-events: none; background: rgb(187, 187, 187);"
                                            style="width: 100px;" readonly>
                                        @error('edit-code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-end">Description</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control @error('edit-desc')
                                is-invalid
                            @enderror"
                                            value="{{ old('edit-desc') ? old('edit-desc') : $cat->description }}"
                                            name="edit-desc">
                                        @error('edit-desc')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-dark btn-sm" name="btn-edit"
                                            value="update">Save</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                                            Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @foreach ($categories as $cat)
        <div class="modal" tabindex="-1" id="modal_delete_cat{{ $cat->code }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this category? <b>{{ $cat->code }}</b> </p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('menu.cat.delete', ['code' => $cat->code]) }}" method="POST">
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

@if (session('ShowNewEntriesCat'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('new-form-cat'));
            modal.show();
        });
    </script>
@endif

@if (session('ShowEditEntriesCat'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editData = @json(session('editData'));
            if (editData) {
                var modal = new bootstrap.Modal(document.getElementById('edit-form-cat' + editData.code));
                modal.show();
            }
        });
    </script>
@endif
