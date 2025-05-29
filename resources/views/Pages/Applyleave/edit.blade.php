@extends('layouts.employee')
@section('title', 'Edit Leave')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Leave Application Form
                        <a href="{{url('show/applyleave')}}" class="btn btn-danger btn-sm float-end">Back</a>
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
                    <form action="{{url('update/applyleave/' . $data->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- start User_id visually-hidden-->
                        <div class="form-group mb-3 visually-hidden">
                            <label for="">Select User:</label>
                            <input type="int" class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                value="{{$data->user_id}}" required autocomplete="user_id" autofocus>
                        </div>
                        <!-- end -->
                        <!-- $leavetype start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_Type:') }}</label>
                            <input type="int" class="form-control @error('leave_type_id') is-invalid @enderror"
                                name="leave_type_id" value="{{$data->leavetype->leave_type}}" required
                                autocomplete="leave_type_id" autofocus readonly>
                        </div>
                        <!-- end -->
                        <!-- start Description -->
                        <div class="form-group mb-3 ">
                            <label for="">{{ __('Description:') }}</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                name="description" value="{{$data->description}}"
                                placeholder="State the reason for Application!" required
                                autofocus>{{$data->description}}</textarea>
                        </div>
                        <!-- end I removed id="mysummernote" on description -->
                        <!-- Leave_From_Start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_From:') }}</label>
                            <input type="date" class="form-control @error('leave_from') is-invalid @enderror"
                                name="leave_from" value="{{$data->leave_from}}" min=<?php echo date('Y-m-d'); ?>
                                required autofocus>
                        </div>
                        <!-- End -->
                        <!-- Leave_To_Start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_To:') }}</label>
                            <input type="date" class="form-control @error('leave_to') is-invalid @enderror"
                                name="leave_to" value="{{$data->leave_to}}" min=<?php echo date('Y-m-d'); ?> required
                                autofocus>
                        </div>
                        <div class="form-group  mb-3">
                            <label for="">Days</label>
                            <input type="text" id="leave_days" name="leave_days"
                                class="form-control @error('leave_days') is-invalid @enderror"
                                value="{{$data->leave_days}}" readonly />
                            @error('leave_days')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="handover_id">Select User to Hand Over:</label>
                            <select id="handover_id" class="form-control @error('handover_id') is-invalid @enderror"
                                name="handover_id" autocomplete="handover_id" autofocus>
                                @if($users)
                                    @foreach($users as $person)
                                        <option value="{{ $person->id }}" 
                                            {{ (old('handover_id') ?? ($data->handover_id ?? Auth::user()->id)) == $person->id ? 'selected' : '' }}>
                                            {{ $person->name . ' ' . $person->last_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('handover_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- <div class="form-group mb-3">
                            <label for="handover_id">Select User to Hand Over:</label>
                            <input id="handover_id" type="text"
                                class="form-control @error('handover_id') is-invalid @enderror" name="handover_id"
                                value="{{ $data->Handover->name . ' ' . $data->Handover->last_name }}"
                                autocomplete="handover_id" />
                            @error('handover_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                        -->
                        <!-- End -->
                        <!-- Submit form -->
                        <div class="form-group mb-3 rounded-pill">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
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