@extends('layouts.adminhr')
@section('title', 'Leaves Report')
@section('content')

<div class="container-fluid px-4">
  <h4 class="mt-4">Leaves Report</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Leaves Report</li>
  </ol>
  <div class="row mt-4">
    <div class="col-lg-12 col-xl-12 col-md-12">

      <div class="card shadow">
        <div class="card-header">
          <h4>Leaves Report
          </h4>
        </div>
        <div class="card-body table-responsive">
          <form method="GET" action="{{ url('adminhr/laporanleave') }}" class="row g-3 mb-4">
            <div class="col-md-3">
              <label for="start_date">Tanggal Awal</label>
              <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
              <label for="end_date">Tanggal Akhir</label>
              <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
              <label for="">Departemen</label>
              <select name="department" class="form-select" >
                <option value="">-- Semua Departemen --</option>
                @foreach ($departments as $dept)
                  <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->dpname }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary me-2">Filter</button>
              <button id="btnCetak" class="btn btn-success mb-0">Cetak Hasil</button>
            </div>
          </form>

          <table id="mydataTable" class="table table-striped table-bordered " class="display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Employee_Name</th>
                <th>Leave_Type_Id</th>
                <th>Description</th>
                <th>Leave_From</th>
                <th>Leave_To</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $item)
                <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->User->name . ' ' . $item->User->last_name}}</td>
                <td>{{$item->leavetype->leave_type}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->leave_from}}</td>
                <td>{{$item->leave_to}}</td>
                <td>
                  <?php
          if ($item->status == '0') {
          echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                   <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                   <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                   </symbol>
                   <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                   <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                   </symbol>
                   <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                   <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                   </symbol>
                   </svg>
                   <div class="alert alert-primary d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                  <div>
                  <b>Pending!</b>
                  </div>
                  </div>';
          }
          if ($item->status == '1') {
          echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </symbol>
                  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                  </symbol>
                  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </symbol>
                  </svg>
                  <div class="alert alert-success d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                  <div>
                  <b>Accepted!</b>
                  </div>
                  </div>';
          }
          if ($item->status == '2') {
          echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </symbol>
                  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                  </symbol>
                  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </symbol>
                  </svg>
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                  <div>
                   <b>Rejected!</b>
                  </div>
                  </div>';
          }
                  ?>
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
@section('scripts')
<script>
  $(document).ready(function() {
    // Inisialisasi DataTable hanya sekali
    var table;
    if (! $.fn.DataTable.isDataTable('#mydataTable')) {
      table = $('#mydataTable').DataTable({
        responsive: true,
      });
    } else {
      table = $('#mydataTable').DataTable(); // ambil instance yg sudah ada
    }

    $('#btnCetak').on('click', function(e) {
      e.preventDefault();

      var startDate = $('input[name="start_date"]').val();
      var endDate = $('input[name="end_date"]').val();
      var department = $('select[name="department"]').val();
      var searchValue = table.search();

      var url = '{{ url("adminhr/cetak/laporanleave") }}';
      var params = new URLSearchParams();

      if (startDate) params.append('start_date', startDate);
      if (endDate) params.append('end_date', endDate);
      if (department) params.append('department', department);
      if (searchValue) params.append('search', searchValue);

      window.open(url + '?' + params.toString(), '_blank');
    });
  });
</script>
@endsection
