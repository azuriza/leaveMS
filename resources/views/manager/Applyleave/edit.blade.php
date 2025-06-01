@extends('layouts.manager')
@section('title', 'Edit Leave')
@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">Leave Management</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Edit Leave</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">

            <div class="card shadow">
                <div class="card-header">
                    <h4>Approve or Reject Leave
                        <a href="{{ url('manager/applyleave') }}" class="btn btn-info btn-sm float-end rounded">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ url('manager/update/applyleave/' . $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row col-md-12 col-lg-12 col-xl-12">
                            <!-- User Info (Readonly) -->
                            <div class="form-group col-6 mb-3">
                                <label for="user_id">User:</label>
                                <input id="user_id" type="text"
                                    class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                    value="{{ $data->User->name . ' ' . $data->User->last_name }}"
                                    autocomplete="user_id" readonly />
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave Type (Readonly) -->
                            <div class="form-group col-6 mb-3">
                                <label for="leave_type_id">{{ __('Leave Type:') }}</label>
                                <input id="leave_type_id" type="text"
                                    class="form-control @error('leave_type_id') is-invalid @enderror"
                                    name="leave_type_id" value="{{ $data->leavetype->leave_type }}"
                                    autocomplete="leave_type_id" readonly />
                                @error('leave_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="description">{{ __('Description:') }}</label>
                                <textarea id="description"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    placeholder="State the reason for Application!"
                                    @if($data->user_id != auth()->user()->id) readonly @endif>{{ $data->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave From -->
                            <div class="form-group col-6 mb-3">
                                <label for="leave_from">{{ __('Leave From:') }}</label>
                                <input id="leave_from" type="date"
                                    class="form-control @error('leave_from') is-invalid @enderror" name="leave_from"
                                    value="{{ $data->leave_from }}" min="{{ date('Y-m-d') }}" @if($data->user_id != auth()->user()->id) readonly @endif />
                                @error('leave_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave To -->
                            <div class="form-group col-6 mb-3" id="leave_to_container">
                                <label for="leave_to">{{ __('Leave To:') }}</label>
                                <input id="leave_to" type="date"
                                    class="form-control @error('leave_to') is-invalid @enderror" name="leave_to"
                                    value="{{ $data->leave_to }}" min="{{ date('Y-m-d') }}" @if($data->user_id != auth()->user()->id) readonly @endif />
                                @error('leave_to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3" id="leave_days">
                                <label for="leave_days">Days</label>
                                <input type="text" id="leave_days" name="leave_days"
                                    class="form-control @error('leave_days') is-invalid @enderror"
                                    value="{{ $data->leave_days }}" @if($data->user_id != auth()->user()->id) readonly @endif/>
                                @error('leave_days')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3 visually-hidden">
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
                            <!-- Update Status -->
                            <div class="form-group col-4 mb-3">
                                <label for="status">{{ __('Update Status:') }}</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    @if($data->user_id == auth()->user()->id) disabled @endif>
                                    <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>--Update Status--
                                    </option>
                                    <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Accepted</option>
                                    <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                {{-- ⬇️ Ini input tersembunyi untuk kirim datanya ke server --}}
                                @if($data->user_id == auth()->user()->id)
                                    <input type="hidden" name="status" value="{{ $data->status }}">
                                @else
                                    {{-- biarkan select aslinya yang terkirim --}}
                                @endif
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-warning rounded">
                                    {{ __('Update!') }}
                                </button>
                            </div>

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
    //    if (leaveFromInput.value) {
    //         leaveToInput.value = leaveFromInput.value;
    //     }

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