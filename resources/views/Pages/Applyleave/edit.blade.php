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
                    <form action="{{url('update/applyleave/' . $data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="sisa_cuti">Sisa Cuti Saat Ini:</label>
                            <input type="text" id="sisa_cuti" name="sisa_cuti"
                                class="form-control"
                                value="{{ $sisaCuti ?? '0' }}" readonly>
                        </div>
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
                            <input type="hidden" id="leave_type_id" value="{{ $data->leave_type_id }}">
                            <input type="text" class="form-control" value="{{ $data->leavetype->leave_type }}" readonly>
                            <!-- <input type="int" class="form-control @error('leave_type_id') is-invalid @enderror"
                                name="leave_type_id" value="{{$data->leavetype->leave_type}}" required
                                autocomplete="leave_type_id" autofocus readonly> -->
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
                        <div class="form-group mb-3" id="document_container" style="display: none;">
                            <div class="form-group mb-3">
                                <label>Dokumen Pendukung Saat Ini:</label><br>
                                <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank">Lihat File</a>
                            </div>

                            <div class="form-group mb-3">
                                <label for="file_path">Ganti Dokumen Pendukung (Opsional)</label>
                                <input id="file_path" type="file" name="file_path" accept="application/pdf,image/jpeg,image/png"
                                    class="form-control @error('file_path') is-invalid @enderror">
                                @error('file_path')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
                        <div class="row align-items-end">
                            <div class="form-group col-6 mb-3" id="handover_container">
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
                            <div class="form-group col-4 mb-3" id="handover_status_container">
                                <label for="handover_status">{{ __('Hand Over Status:') }}</label>
                                <input type="text" class="form-control" value="@php
                                    $status = (int) $data->handover_status;
                                    echo match($status) {
                                        1 => 'Accepted',
                                        2 => 'Rejected',
                                        default => 'Pending'
                                    };
                                @endphp" readonly>
                                {{-- input hidden untuk dikirim ke server --}}
                                <input type="hidden" name="handover_status" id="hidden_handover_status" value="{{ $data->handover_status }}">

                                @error('handover_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-end">
                            <div class="form-group col-6 mb-3" id="handover2_container">
                                <label for="handover_id_2">Select User to Hand Over 2 (Optional):</label>
                                <select id="handover_id_2" class="form-control @error('handover_id_2') is-invalid @enderror"
                                    name="handover_id_2" autocomplete="handover_id_2" autofocus>
                                    
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
                            <div class="form-group col-4 mb-3" id="handover2_status_container">
                                <label for="handover2_status">{{ __('Hand Over 2 Status:') }}</label>
                                <input type="text" class="form-control" value="@php
                                    $status = (int) $data->handover2_status;
                                    echo match($status) {
                                        1 => 'Accepted',
                                        2 => 'Rejected',
                                        default => 'Pending'
                                    };
                                @endphp" readonly>
                                {{-- input hidden untuk dikirim ke server --}}
                                <input type="hidden" name="handover2_status" id="hidden_handover2_status" value="{{ $data->handover2_status }}">

                                @error('handover2_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-end">
                            <div class="form-group col-6 mb-3" id="handover3_container">
                                <label for="handover_id_3">Select User to Hand Over 3 (Optional):</label>
                                <select id="handover_id_3" class="form-control @error('handover_id_3') is-invalid @enderror"
                                    name="handover_id_3" autocomplete="handover_id_3" autofocus>
                                    
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
                            <div class="form-group col-4 mb-3" id="handover3_status_container">
                                <label for="handover3_status">{{ __('Hand Over 3 Status:') }}</label>
                                <input type="text" class="form-control" value="@php
                                    $status = (int) $data->handover3_status;
                                    echo match($status) {
                                        1 => 'Accepted',
                                        2 => 'Rejected',
                                        default => 'Pending'
                                    };
                                @endphp" readonly>
                                {{-- input hidden untuk dikirim ke server --}}
                                <input type="hidden" name="handover3_status" id="hidden_handover3_status" value="{{ $data->handover3_status }}">

                                @error('handover3_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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

<!-- JS to hide Leave To -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const leaveType = document.getElementById("leave_type_id");
        const documentContainer = document.getElementById("document_container");
        const handover_container = document.getElementById("handover_container");
        const handover2_container = document.getElementById("handover2_container");
        const handover3_container = document.getElementById("handover3_container");

        function toggleDocumentContainer() {
            if (leaveType && documentContainer) {
                const typeVal = leaveType.value.trim(); // pastikan tidak ada spasi
                if (typeVal === "8" || typeVal === "9") {
                    documentContainer.style.display = "block";
                    handover_container.style.display = "none";
                    handover2_container.style.display = "none";
                    handover3_container.style.display = "none";
                } else {
                    documentContainer.style.display = "none";
                    handover_container.style.display = "block";
                    handover2_container.style.display = "block";
                    handover3_container.style.display = "block";
                }
            }
        }

        toggleDocumentContainer(); // panggil saat halaman dimuat
    });   
</script>
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