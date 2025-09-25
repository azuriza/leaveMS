@extends('layouts.direktur')
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
                        @if ($isOwnData)
                        <a href="{{ url('direktur/applyleaveself') }}" class="btn btn-info btn-sm float-end rounded">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                        @endif
                        @if (!$isOwnData)
                        <a href="{{ url('direktur/applyleave') }}" class="btn btn-info btn-sm float-end rounded">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                        @endif
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
                    <form action="{{ url('direktur/update/applyleave/' . $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group col-6 mb-3">
                                <label for="user_id">User:</label>
                                <input id="user_id" type="text"
                                    class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                    value="{{ $data->user->name . ' ' . $data->user->last_name }}"
                                    autocomplete="user_id" readonly />
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Leave Type (Readonly) -->
                            <div class="form-group col-6 mb-3">
                                <label for="leave_type_id">{{ __('Leave Type:') }}</label>
                                <input type="hidden" id="leave_type_id" value="{{ $data->leave_type_id }}">
                                <input type="text" class="form-control" value="{{ $data->leavetype->leave_type }}" readonly>
                                <!-- <input id="leave_type_id" type="text"
                                    class="form-control @error('leave_type_id') is-invalid @enderror"
                                    name="leave_type_id" value="{{ $data->leavetype->leave_type }}"
                                    autocomplete="leave_type_id" readonly />
                                @error('leave_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror -->
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
                            <div class="form-group mb-3" id="document_container">
                                <div class="form-group mb-3">
                                    <label>Dokumen Pendukung Saat Ini:</label><br>
                                    <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank">Lihat File</a>
                                </div>
                            </div>
                            <div class="form-group mb-3" id="document2_container">
                                <div class="form-group mb-3">
                                    <label for="file_path">Ganti Dokumen Pendukung (Opsional)</label>
                                    <input id="file_path" type="file" name="file_path" accept="application/pdf,image/jpeg,image/png"
                                        class="form-control @error('file_path') is-invalid @enderror">
                                    @error('file_path')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
                            <div class="form-group col-6 mb-3" id="handover_container">
                                <label for="handover_id">Select User to Hand Over:</label>
                                <select id="handover_id" class="form-control @error('handover_id') is-invalid @enderror"
                                    name="handover_id" autocomplete="handover_id" disabled>
                                    @if($users)
                                        @foreach($users as $person)
                                            <option value="{{ $person->id }}"
                                                {{ (old('handover_id') ?? $data->handover_id) == $person->id ? 'selected' : '' }}>
                                                {{ $person->name . ' ' . $person->last_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="handover_id" value="{{ $data->handover_id }}">
                                @error('handover_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3" id="handover2_container">
                                <label for="handover_id_2">Select User to Hand Over 2 (Optional):</label>
                                <select id="handover_id_2" class="form-control @error('handover_id_2') is-invalid @enderror"
                                    name="handover_id_2" autocomplete="handover_id_2" disabled>
                                    
                                    <option value="">-- Pilih User --</option> {{-- opsi kosong --}}

                                    @if($users)
                                        @foreach($users as $person)
                                            <option value="{{ $person->id }}" 
                                                {{ (old('handover_id_2') ?? $data->handover_id_2) == $person->id ? 'selected' : '' }}>
                                                {{ $person->name . ' ' . $person->last_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('handover_id_2')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-3" id="handover3_container">
                                <label for="handover_id_3">Select User to Hand Over 3 (Optional):</label>
                                <select id="handover_id_3" class="form-control @error('handover_id_3') is-invalid @enderror"
                                    name="handover_id_3" autocomplete="handover_id_3" disabled>
                                    
                                    <option value="">-- Pilih User --</option> {{-- opsi kosong --}}

                                    @if($users)
                                        @foreach($users as $person)
                                            <option value="{{ $person->id }}" 
                                                {{ (old('handover_id_3') ?? $data->handover_id_3) == $person->id ? 'selected' : '' }}>
                                                {{ $person->name . ' ' . $person->last_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('handover_id_3')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3" id="reason_container">
                                <label for="reason">{{ __('Reason:') }}</label>
                                <textarea id="reason"
                                class="form-control @error('reason') is-invalid @enderror" name="reason"
                                placeholder="State the reason for status rejected or accept with condition">{{ $data->reason }}</textarea>
                                @error('reason')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Update Status -->
                            <div class="form-group col-4 mb-3" id="status_container">
                                <label for="status">{{ __('Update Status:') }}</label>
                                <select id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>--Update Status--
                                    </option>
                                    <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Accepted</option>
                                    <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                {{-- input hidden untuk dikirim ke server --}}
                                <input type="hidden" name="status" id="hidden_status" value="{{ $data->status }}">

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
        const documentContainer = document.getElementById("document_container");
        const documentContainer2 = document.getElementById("document2_container");
        const reasonContainer = document.getElementById("reason_container");
        const reasontext = document.getElementById("reason");
        const handover_container = document.getElementById("handover_container");
        const handover2_container = document.getElementById("handover2_container");
        const handover3_container = document.getElementById("handover3_container"); 
        const statusContainer = document.getElementById("status_container"); 

        const statusSelect = document.getElementById("status");
        const hiddenStatus = document.getElementById("hidden_status");
        
        // isOwnData dari backend (boolean)
        const isOwnData = @json($isOwnData);

        function toggleDocumentContainer() {
            if (leaveType && documentContainer && handover_container) {
                const typeVal = leaveType.value.trim(); // pastikan tidak ada spasi
                if (!isOwnData) {// jika edit employee                    
                    if (typeVal === "8" || typeVal === "9") {
                        documentContainer.style.display = "block";
                        documentContainer2.style.display = "none";
                        handover_container.style.display = "none";
                        handover2_container.style.display = "none";
                        handover3_container.style.display = "none";
                        statusSelect.disabled = true;
                    } else {
                        documentContainer.style.display = "none";
                        documentContainer2.style.display = "none";
                        handover_container.style.display = "none";
                        handover2_container.style.display = "none";
                        handover3_container.style.display = "none";
                        statusContainer.style.display = "block";
                        statusSelect.disabled = false;
                    }
                    //reasonContainer.style.display = "block";                    
                } else {// jika edit self
                    if (typeVal === "8" || typeVal === "9") {
                        documentContainer.style.display = "block";
                        documentContainer2.style.display = "block";
                        handover_container.style.display = "none";
                        handover2_container.style.display = "none";
                        handover3_container.style.display = "none";
                    } else {
                        documentContainer.style.display = "none";
                        documentContainer2.style.display = "none";
                        handover_container.style.display = "none";
                        handover2_container.style.display = "none";
                        handover3_container.style.display = "none";
                    }
                    if (hiddenStatus !== 0){
                        reasonContainer.style.display = "block";
                        reasontext.readOnly = true;   
                    } else {
                        reasonContainer.style.display = "none";
                    }
                    statusContainer.style.display = "none";
                }
            }
        }

        toggleDocumentContainer(); // panggil saat halaman dimuat

        if (statusSelect && hiddenStatus) {
            statusSelect.addEventListener("change", function () {
                hiddenStatus.value = statusSelect.value;
            });
        }
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