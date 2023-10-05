@extends('employee.layouts.master')

@section('container')
    {{-- New Form --}}
    <div class="row" id="new-cat-form">
        <div class="col-6">
            <div class="card mt-3 shadow" style="border: none; border-radius: 30px;">
                <div class="card-body">
                    <form class="mb-2 mt-2">
                        <div class="row mb-3">
                            <label for="code" class="col-sm-3 col-form-label text-end">Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="code" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label text-end">Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-dark btn-sm" disabled>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="row" id="edit-cat-form">
        <div class="col-6">
            <div class="card mt-3 shadow" style="border: none; border-radius: 30px;">
                <div class="card-body">
                    <form class="mb-2 mt-2">
                        <div class="row mb-3">
                            <label for="code" class="col-sm-3 col-form-label text-end">Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="code">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label text-end">Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-dark btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
