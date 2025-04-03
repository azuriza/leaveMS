@extends('layouts.employee')
@section('title', 'Leaves')
@section('content')
<?php

/**
 * Count the number of working days between two dates.
 *
 * This function calculate the number of working days between two given dates,
 * taking account of the Public festivities, Easter and Easter Morning days,
 * the day of the Patron Saint (if any) and the working Saturday.
 *
 * @param   string  $date1    Start date ('YYYY-MM-DD' format)
 * @param   string  $date2    Ending date ('YYYY-MM-DD' format)
 * @param   boolean $workSat  TRUE if Saturday is a working day
 * @param   string  $patron   Day of the Patron Saint ('MM-DD' format)
 * @return  integer           Number of working days ('zero' on error)
 *
 * @author Massimo Simonini <massiws@gmail.com>
 */
function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
  if (!defined('SATURDAY')) define('SATURDAY', 6);
  if (!defined('SUNDAY')) define('SUNDAY', 0);

  // Array of all public festivities
  $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
  // The Patron day (if any) is added to public festivities
  if ($patron) {
    $publicHolidays[] = $patron;
  }

  /*
   * Array of all Easter Mondays in the given interval
   */
  $yearStart = date('Y', strtotime($date1));
  $yearEnd   = date('Y', strtotime($date2));

  for ($i = $yearStart; $i <= $yearEnd; $i++) {
    $easter = date('Y-m-d', easter_date($i));
    list($y, $m, $g) = explode("-", $easter);
    $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
    $easterMondays[] = $monday;
  }

  $start = strtotime($date1);
  $end   = strtotime($date2);
  $workdays = 0;
  for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
    $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
    $mmgg = date('m-d', $i);
    if ($day != SUNDAY &&
      !in_array($mmgg, $publicHolidays) &&
      !in_array($i, $easterMondays) &&
      !($day == SATURDAY && $workSat == FALSE)) {
        $workdays++;
    }
  }

  return intval($workdays);
}
?>

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
                <th>Leave_Type</th>
                <th>Leave_From</th>
                <th>Leave_To</th>
                <th>Applied_At</th>
                <th>Days_applied_For</th>

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
            <!-- <td>{{$item->User->name . ' ' . $item->User->last_name}}</td> -->
            <td>{{$item->leavetype->leave_type}}</td>
            <td>{{$item->leave_from}}</td>
            <td>{{$item->leave_to}}</td>
            <td>{{$item->created_at}}</td>
            <td>
            <?php
            
        // Lets declare variables
        $fdate = $item->leave_from;
        $tdate = $item->leave_to;
        $datetime1 = new Datetime($fdate);
        $datetime2 = new Datetime($tdate);
        $interval = $datetime1->diff($datetime2);
        // $days = $interval->format('%a');
        $days = getWorkdays($fdate,$tdate);
        echo $days;
            ?>
            </td>

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