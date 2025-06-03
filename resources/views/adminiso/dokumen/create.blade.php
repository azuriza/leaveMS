@extends('layouts.adminiso')
@section('title', 'Add Documents')

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
                    <h4>Create Documents
                        <a href="{{ url('adminiso/dokumen') }}" class="btn btn-danger float-end rounded-pill">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('adminiso/store/dokumen') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="kategori_id">Kategori Dokumen</label>
                            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $dokumen->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="judul">Judul</label>
                            <input id="judul" type="text" name="judul"
                                class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}"
                                autofocus />
                            @error('judul')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="file_path">File PDF:</label>
                             <input id="file_path" type="file" name="file_path" accept="application/pdf"
                                class="form-control @error('file_path') is-invalid @enderror" value="{{ old('file_path') }}"
                                autofocus />
                            @error('file_path')
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('file_path').addEventListener('change', function() {
        const allowedTypes = ['application/pdf'];
        const file = this.files[0];

        if (file && !allowedTypes.includes(file.type)) {
            alert('Hanya file PDF yang diperbolehkan.');
            this.value = '';
        }
    });
  });
</script>
@endsection