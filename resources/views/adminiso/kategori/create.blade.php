@extends('layouts.adminiso')
@section('title', 'Add Category Documents')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Category Documents</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Category Documents</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">

            <div class="card shadow">
                <div class="card-header">
                    <h4>Create Category Documents
                        <a href="{{ url('adminiso/kategori') }}" class="btn btn-danger float-end rounded-pill">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('adminiso/store/kategori') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input id="nama" type="text" name="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                autofocus />
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary rounded">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection