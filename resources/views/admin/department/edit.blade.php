@extends('layouts.backend')
@section('title', 'Edit Department')
@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">Department</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Department</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">

            <div class="card shadow">
                <div class="card-header">
                    <h4>Edit Department
                        <a href="{{ url('admin/departments') }}" class="btn btn-danger btn-sm float-end rounded-pill">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/update/department/' . $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="dpname">Name:</label>
                            <input id="dpname" type="text" name="dpname"
                                value="{{ old('dpname', $department->dpname) }}"
                                class="form-control @error('dpname') is-invalid @enderror" autofocus />
                            @error('dpname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Approved by On OTC:</label>
                            <textarea id="description" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                autofocus>{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Approval Status:</label>
                            <select id="status" name="status"
                                class="form-control selectpicker @error('status') is-invalid @enderror">
                                <option value="0" {{ old('status', $department->status) == '0' ? 'selected' : '' }}>
                                    Waiting Approval
                                </option>
                                <option value="1" {{ old('status', $department->status) == '1' ? 'selected' : '' }}>
                                    Approved
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection