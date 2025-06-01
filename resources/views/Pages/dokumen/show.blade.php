@extends('layouts.employee')

@section('title', 'Documents')

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
                <div class="card-body table-responsive">
                    <form method="GET" action="{{ url()->current() }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="kategori_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <table id="mydataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumens as $index => $empdata)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $empdata->kategori->nama ?? '-' }}</td>
                                    <td>{{ $empdata->judul }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $empdata->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Lihat File
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection