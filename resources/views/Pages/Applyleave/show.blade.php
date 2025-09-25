@extends('layouts.employee')
@section('title', 'Leaves')
@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-rounded shadow">
        <div class="card-header bg-info">
          <h4>Leave Status
          </h4>
        </div>
        <div class="card-body table-responsive">

          <table id="mydataTable" class="table table-striped table-bordered" class="display nowrap" style="width:100%">
            <thead>
              <tr>
                <!-- I should comment this out cause already its the auth user <th>User_Id</th> -->
                <!-- <th>Name</th> -->
                <th>Leave Type</th>
                <th>Description</th>
                <th>Leave From</th>
                <th>Leave To</th>
                <!-- <th>Applied_At</th> -->
                <th>Days</th>

                <th>Status</th>
                <th>Edit</th>
                <!-- <th>Delete</th> -->
              </tr>
            </thead>
            <tbody>

              @foreach($data as $item)
              @if($item->user_id == Auth::user()->id)
            <tr>
            <!--Remember that we had r/ship btw leave and leavetype hence i pass $item->leavetype->leave_type as if i was inside leave type instead of showing $item->leave_type_id to display name instead of id <td>{{$item->user_id}}</td> -->
            <!-- <td>{{$item->user->name . ' ' . $item->user->last_name}}</td> -->
            <td>{{$item->leavetype->leave_type}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->leave_from}}</td>
            <td>{{$item->leave_to}}</td>
            <!-- <td>{{$item->created_at}}</td> -->
            <td>{{ DateHelper::getWorkdays($item->leave_from, $item->leave_to) }}</td>
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
                  <b>Pending</b>
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
                  <b>Accepted</b>
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
                   <b>Rejected</b>
                  </div>
                  </div>';
        }
            ?>
            </td>
            <td>
            <a href="{{url('edit/applyleave/' . $item->id)}}" class="btn btn-success btn-sm">Update</a>
            </td>

            <!-- <td>
            <form action="{{url('delete/applyleave/'.$item->id)}}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>


            </td>  -->

            </tr>

        @endif
        @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection