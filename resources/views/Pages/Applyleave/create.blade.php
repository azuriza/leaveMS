@extends('layouts.employee')
@section('title', 'Apply Leave')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Leave Application Form
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{$error}}</div>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{url('add/applyleave')}}" method="POST">
                        @csrf
                        <!-- start User_id visually-hidden-->
                        <div class="form-group mb-3 visually-hidden">
                            <label for="">Select User:</label>
                            <select type="int" class="form-control @error('user_id') is-invalid @enderror"
                                name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>

                                @if($users)
                                    @foreach($users as $person)

                                        <option value="{{$person->id}}" @if($person->name . ' ' . $person->last_name == Auth::user()->name . ' ' . Auth::user()->last_name) selected
                                        @endif> {{$person->name . ' ' . $person->last_name}} </option>

                                    @endforeach
                                @endif
                            </select>
                            <!-- <input type="int" class="form-control rounded-pill" name="user_id" value="{{Auth::user()->id}}" required autofocus> -->
                        </div>
                        <!-- end -->
                        <!-- $leavetype start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_Type:') }}</label>
                            <select type="int" class="form-control @error('leave_type_id') is-invalid @enderror"
                                name="leave_type_id" value="{{ old('leave_type_id') }}" required
                                autocomplete="leave_type_id" autofocus>
                                <option value="">--Select Leave_Type--</option>
                                @if($leavetype)
                                    @foreach($leavetype as $use)
                                        <option value="{{$use->id}}" {{$use->leave_type == '$use->leave_type' ? 'selected' : ''}}>
                                            {{$use->leave_type}} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- end -->
                        <!-- start Description -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Description:') }}</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                name="description" value="{{ old('description') }}"
                                placeholder="State the reason for Application!" required autofocus></textarea>
                        </div>
                        <!-- end I removed id="mysummernote" on description -->
                        <!-- Leave_From_Start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_From:') }}</label>
                            <input type="date" class="form-control @error('leave_from') is-invalid @enderror"
                                name="leave_from" value="{{ old('leave_from') }}" min=<?php echo date('Y-m-d'); ?>
                                required autofocus>
                        </div>
                        <!-- End -->
                        <!-- Leave_To_Start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_To:') }}</label>
                            <input type="date" class="form-control @error('leave_to') is-invalid @enderror"
                                name="leave_to" value="{{ old('leave_to') }}" min=<?php echo date('Y-m-d'); ?> required
                                autofocus>
                        </div>
                        <div class="form-group  mb-3">
                            <label for="">Days</label>
                            <input type="text" id="leave_days" name="leave_days"
                                class="form-control @error('leave_days') is-invalid @enderror"
                                value="{{ old('leave_days') }}" readonly />
                            @error('leave_days')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                                <label for="handover_id">Select User to Hand Over:</label>
                                <select type="int" class="form-control @error('handover_id') is-invalid @enderror"
                                name="handover_id" value="{{ old('handover_id') }}" required autocomplete="handover_id" autofocus>

                                @if($users)
                                    @foreach($users as $person)

                                        <option value="{{$person->id}}" @if($person->name . ' ' . $person->last_name == Auth::user()->name . ' ' . Auth::user()->last_name) selected
                                        @endif> {{$person->name . ' ' . $person->last_name}} </option>

                                    @endforeach
                                @endif
                                </select>
                                @error('handover_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <!-- End -->
                        <!-- Submit form -->
                        <div class="form-group mb-3 rounded-pill">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Apply') }}
                            </button>
                        </div>
                        <!-- End -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    function hitungHariKerja() {
        const from = document.querySelector('input[name="leave_from"]').value;
        const to = document.querySelector('input[name="leave_to"]').value;

        if (from && to) {
            fetch(`/api/hitung-hari-kerja?from=${from}&to=${to}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('leave_days').value = data.jumlah;
                })
                .catch(error => {
                    console.error('Gagal hitung hari kerja:', error);
                });
        }
    }

    document.querySelector('input[name="leave_from"]').addEventListener('change', hitungHariKerja);
    document.querySelector('input[name="leave_to"]').addEventListener('change', hitungHariKerja);
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    function hitungHariKerja() {
        const from = document.querySelector('input[name="leave_from"]').value;
        const to = document.querySelector('input[name="leave_to"]').value;

        if (from && to) {
            fetch(`/api/hitung-hari-kerja?from=${from}&to=${to}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('leave_days').value = data.jumlah;
                })
                .catch(error => {
                    console.error('Gagal hitung hari kerja:', error);
                });
        }
    }

    const leaveFrom = document.querySelector('input[name="leave_from"]');
    const leaveTo = document.querySelector('input[name="leave_to"]');

    if(leaveFrom && leaveTo) {
        leaveFrom.addEventListener('change', hitungHariKerja);
        leaveTo.addEventListener('change', hitungHariKerja);
    } else {
        console.error('Input leave_from atau leave_to tidak ditemukan!');
    }
});
</script> -->
@endsection