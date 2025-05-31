@extends('layouts.adminiso')
@section('title', 'Edit Documents')
@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">Documents</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Documents</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">

            <div class="card shadow">
                <div class="card-header">
                    <h4>Edit Documents
                        <a href="{{ url('adminiso/dokumen') }}" class="btn btn-danger btn-sm float-end rounded-pill">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('adminiso/update/dokumen/' . $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="judul">Judul:</label>
                            <input id="judul" type="text" name="judul"
                                value="{{ old('judul', $dokumen->judul) }}"
                                class="form-control @error('judul') is-invalid @enderror" autofocus />
                            @error('judul')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label>File PDF Saat Ini:</label><br>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">Lihat File</a>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file_path">Ganti File PDF (Opsional)</label>
                            <input id="file_path" type="file" name="file_path" accept="application/pdf"
                                class="form-control @error('file_path') is-invalid @enderror">
                            @error('file_path')
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