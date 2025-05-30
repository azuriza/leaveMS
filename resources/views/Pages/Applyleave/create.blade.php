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
                        <div class="form-group mb-3">
                            <label for="sisa_cuti">Sisa Cuti Saat Ini:</label>
                            <input type="text" id="sisa_cuti" name="sisa_cuti"
                                class="form-control"
                                value="{{ $sisaCuti ?? '0' }}" readonly>
                        </div>
                        <!-- $leavetype start -->
                        <div class="form-group mb-3">
                            <label for="">{{ __('Leave_Type:') }}</label>
                            <select type="int" id="leave_type_id" class="form-control @error('leave_type_id') is-invalid @enderror"
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
        const leaveType = document.getElementById("leave_type_id");
        const fromInput = document.querySelector('input[name="leave_from"]');
        const toInput = document.querySelector('input[name="leave_to"]');
        const from = fromInput.value;
        const to = toInput.value;

        // Kosongkan nilai dulu
        document.getElementById('leave_days').value = '';

        if (!from) return;

        if (leaveType.value === "10") {
            toInput.value = from;
            document.getElementById('leave_days').value = "0,5";
            return;
         }

        if (from && to) {
            const fromDate = new Date(from);
            const toDate = new Date(to);

            if (fromDate > toDate) {
                console.warn("Tanggal mulai lebih besar dari tanggal selesai");
                return;
            }           

            if (leaveType.value !== "10") {
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
    }

    // Sinkronisasi tanggal & hitung saat "leave_from" diubah
    document.querySelector('input[name="leave_from"]').addEventListener('change', function () {
        const from = this.value;
        const toInput = document.querySelector('input[name="leave_to"]');
        
        if (!toInput.value) {
            toInput.value = from;
        }

        hitungHariKerja();
    });

    // Hitung ulang saat "leave_to" atau "leave_type" diubah
    document.querySelector('input[name="leave_to"]').addEventListener('change', hitungHariKerja);
    document.getElementById("leave_type_id").addEventListener('change', hitungHariKerja);
</script>

@endsection