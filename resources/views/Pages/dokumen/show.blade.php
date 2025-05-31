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
                    <table id="mydataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumens as $index => $empdata)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
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