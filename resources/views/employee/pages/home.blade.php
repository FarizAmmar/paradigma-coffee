@extends('employee.layouts.master')

@section('container')
    @if (auth()->user()->access != 'EMP')
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

        <div class="{{ session('ShowNewEntries') ? 'd-none' : '' }} card mb-3 mt-3 shadow"
            style="border: none; border-radius: 30px;" id="view-form">
            <div class="card-body overflow-x-auto">
                {{-- Caption Header --}}
                <div class="container mb-4 mt-3">
                    <div class="row">
                        <div class="col-12">
                            <b>Employee</b>
                        </div>
                        <div class="col-12">
                            <span class="text-secondary">A list of all the employee in your account including their
                                username,
                                email and role.</span>
                        </div>
                    </div>
                </div>
                {{-- Table Employee --}}
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <caption>{{ $employees->links() }}</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Option</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($employees->count() > 0)
                                    @foreach ($employees as $emp)
                                        <tr>
                                            <td>
                                                <button class="btn btn-light btn-sm mx-1" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#edit-form{{ $emp->id }}">
                                                    <i class='bx bxs-pencil'></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm mx-1" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#delete-form">
                                                    <i class='bx bxs-trash-alt'></i>
                                                </button>
                                            </td>
                                            <td>{{ $emp->username }}</td>
                                            <td>{{ $emp->email }}</td>
                                            <td>
                                                @switch($emp->access)
                                                    @case('ADM')
                                                        ADM - Administrator
                                                    @break

                                                    @case('EMP')
                                                        EMP - Employee
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="4">
                                            Employee has no record
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- New Entries --}}
        <div class="row">
            <div class="col-6">
                <div class="{{ session('ShowNewEntries') ? '' : 'd-none' }} card mb-3 mt-3 shadow"
                    style="border: none; border-radius: 30px;" id="new-form">
                    <div class="card-body overflow-x-auto">
                        {{-- Caption Header --}}
                        <div class="container mb-4 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <b>New Employee</b>
                                </div>
                                <div class="col-12">
                                    <span class="text-secondary">This form field is mandatory, please fill
                                        carefully.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form New --}}
                        <form action="{{ route('emp.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row mb-3">
                                <label for="new-username" class="col-sm-4 col-form-label text-end">Username</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control @error('new-username')
                                is-invalid
                            @enderror"
                                        id="new-username" name="new-username" value="{{ old('new-username') }}">
                                    @error('new-username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new-email" class="col-sm-4 col-form-label text-end">Email</label>
                                <div class="col-sm-8">
                                    <input type="email"
                                        class="form-control @error('new-email')
                            is-invalid
                        @enderror"
                                        value="{{ old('new-email') }}" id="new-email" name="new-email">
                                    @error('new-email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new-password" class="col-sm-4 col-form-label text-end">Password</label>
                                <div class="col-sm-8">
                                    <input type="password"
                                        class="form-control @error('new-password')
                            is-invalid
                        @enderror"
                                        id="new-password" name="new-password">
                                    @error('new-password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new-password_confirmation" class="col-sm-4 col-form-label text-end">Confirm
                                    Password</label>
                                <div class="col-sm-8">
                                    <input type="password"
                                        class="form-control @error('new-password_confirmation')
                                is-invalid
                            @enderror"
                                        id="new-password_confirmation" name="new-password_confirmation">
                                    @error('new-password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new-access" class="col-sm-4 col-form-label text-end">Permissions</label>
                                <div class="col-sm-8">
                                    <select
                                        class="form-control @error('new-access')
                                is-invalid
                            @enderror"
                                        name="new-access" id="new-access">
                                        <option value="" hidden selected>Choose Permissions</option>
                                        <option value="ADM">ADM - Admin</option>
                                        <option value="EMP">EMP - Employee</option>
                                    </select>
                                    @error('new-access')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-dark" name="btn-new"
                                        value="new">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Entries --}}
        @foreach ($employees as $emp)
            <div class="modal modal-lg" tabindex="-1" id="edit-form{{ $emp->id }}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Entries</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('emp.update', ['id' => $emp->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row mb-3">
                                    <label for="edit-username" class="col-sm-4 col-form-label text-end">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control @error('edit-username')
                                    is-invalid
                                @enderror"
                                            name="edit-username" value="{{ $emp->username }}">
                                        @error('edit-username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-email" class="col-sm-4 col-form-label text-end">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email"
                                            class="form-control @error('edit-email')
                                is-invalid
                            @enderror"
                                            name="edit-email" value="{{ $emp->email }}">
                                        @error('edit-email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-password" class="col-sm-4 col-form-label text-end">New
                                        Password</label>
                                    <div class="col-sm-8">
                                        <input type="password"
                                            class="form-control @error('edit-password')
                                is-invalid
                            @enderror"
                                            name="edit-password">
                                        @error('edit-password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-password_confirmation"
                                        class="col-sm-4 col-form-label text-end">Confirm
                                        Password</label>
                                    <div class="col-sm-8">
                                        <input type="password"
                                            class="form-control @error('edit-password_confirmation')
                                    is-invalid
                                @enderror"
                                            name="edit-password_confirmation">
                                        @error('edit-password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="edit-access" class="col-sm-4 col-form-label text-end">Permissions</label>
                                    <div class="col-sm-8">
                                        <select
                                            class="form-control @error('edit-access')
                                    is-invalid
                                @enderror"
                                            name="edit-access">
                                            <option value="{{ $emp->access }}" hidden selected>
                                                @switch($emp->access)
                                                    @case('ADM')
                                                        ADM - Administrator
                                                    @break

                                                    @case('EMP')
                                                        EMP - Employee
                                                    @break

                                                    @default
                                                @endswitch
                                            </option>
                                            <option value="ADM">ADM - Admin</option>
                                            <option value="EMP">EMP - Employee</option>
                                        </select>
                                        @error('edit-access')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row text-end">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-dark btn-sm" name="btn-update"
                                            value="update">Save</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Delete Popup / Modal --}}
        @foreach ($employees as $emp)
            <div class="modal" tabindex="-1" id="delete-form">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure, you want to delete this user?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('emp.delete', ['id' => $emp->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-dark btn-sm" type="submit">Delete</button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection


@if (session('ShowModalEdit'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editData = @json(session('editData'));
            if (editData) {
                var modal = new bootstrap.Modal(document.getElementById('edit-form' + editData.id));
                modal.show();
            }
        });
    </script>
@endif
