@extends('layouts.manager')
@section('title', 'Apply Leave')
@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">Leave Application</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Apply Leave</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Leave Application Form
                        <a href="{{ url('manager/applyleave') }}" class="btn btn-danger btn-sm float-end">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('manager/add/applyleave') }}" method="POST">
                        @csrf
                        <div class="row col-md-12 col-lg-12 col-xl-12">
                            <!-- Select User -->
                            <div class="form-group col-6 mb-3 visually-hidden">
                                <label for="user_id">Select User:</label>
                                <select type="int" class="form-control @error('user_id') is-invalid @enderror"
                                name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>

                                @if($users)
                                    @foreach($users as $person)

                                        <option value="{{$person->id}}" @if($person->name . ' ' . $person->last_name == Auth::user()->name . ' ' . Auth::user()->last_name) selected
                                        @endif> {{$person->name . ' ' . $person->last_name}} </option>

                                    @endforeach
                                @endif
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave Type -->
                            <div class="form-group col-6 mb-3">
                                <label for="leave_type_id">{{ __('Leave Type:') }}</label>
                                <select id="leave_type_id"
                                    class="form-control @error('leave_type_id') is-invalid @enderror"
                                    name="leave_type_id" value="{{ old('leave_type_id') }}" autocomplete="leave_type_id"
                                    autofocus>
                                    <option value="">--Select Leave Type--</option>
                                    @if($leavetype)
                                        @foreach($leavetype as $type)
                                            <option value="{{ $type->id }}" {{ $type->id == old('leave_type_id') ? 'selected' : '' }}>
                                                {{ $type->leave_type }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('leave_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group  mb-3">
                                <label for="description">{{ __('Description:') }}</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                    placeholder="State the reason for Application!" autofocus>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Leave From -->
                            <div class="form-group col-6 mb-3">
                                <label for="leave_from">{{ __('Leave From:') }}</label>
                                <input id="leave_from" type="date"
                                    class="form-control @error('leave_from') is-invalid @enderror" name="leave_from"
                                    value="{{ old('leave_from') }}" min="{{ date('Y-m-d') }}" autofocus />
                                @error('leave_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave To -->
                            <div class="form-group col-6 mb-3" id="leave_to_container">
                                <label for="leave_to">{{ __('Leave To:') }}</label>
                                <input id="leave_to" type="date"
                                    class="form-control @error('leave_to') is-invalid @enderror" name="leave_to"
                                    value="{{ old('leave_to') }}" min="{{ date('Y-m-d') }}" autofocus />
                                @error('leave_to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3" id="leave_to_container">
                                <label for="leave_days">Days</label>
                                <input type="text" id="leave_days" name="leave_days"
                                    class="form-control @error('leave_days') is-invalid @enderror"
                                    value="{{ old('leave_days') }}" readonly />
                                @error('leave_days')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3">
                                <label for="user_id">Select User to Hand Over:</label>
                                <select type="int" class="form-control @error('user_id') is-invalid @enderror"
                                name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>

                                @if($users)
                                    @foreach($users as $person)

                                        <option value="{{$person->id}}" @if($person->name . ' ' . $person->last_name == Auth::user()->name . ' ' . Auth::user()->last_name) selected
                                        @endif> {{$person->name . ' ' . $person->last_name}} </option>

                                    @endforeach
                                @endif
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-group col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Apply') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS to hide Leave To -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const leaveType = document.getElementById("leave_type_id");
        const leaveToContainer = document.getElementById("leave_to_container");
        const leaveFromInput = document.getElementById("leave_from");
        const leaveToInput = document.getElementById("leave_to");
        const leaveDays = document.getElementById("leave_days");

         // Otomatis isi Leave To saat Leave From dipilih
        //  leaveFromInput.addEventListener("change", function () {
        //     leaveToInput.value = leaveFromInput.value;
        // });
 
        function toggleLeaveTo() {
            if (leaveType.value === "10") { // misal ID leave_type untuk 'sick' = 1
                leaveToContainer.style.display = "none";
                leaveToInput.value = leaveFromInput.value;
                leaveDays.value = "0,5"
            } else {
                leaveToContainer.style.display = "block";
            }
        }

       // Panggil saat halaman dimuat
       if (leaveFromInput.value) {
            leaveToInput.value = leaveFromInput.value;
        }

        // Call on change
        leaveType.addEventListener("change", toggleLeaveTo);
    });
</script>
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