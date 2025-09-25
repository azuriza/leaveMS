<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p.info {
            text-align: center;
            font-weight: 600;
            margin: 10px 0 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #eee;
            font-weight: 700;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #d6eaff;
        }

        /* Status warna berbeda */
        .status-pending {
            color: #d98c00; /* oranye gelap */
            font-weight: 600;
        }
        .status-approved {
            color: #007a00; /* hijau */
            font-weight: 600;
        }
        .status-rejected {
            color: #c00; /* merah */
            font-weight: 600;
        }
        .status-unknown {
            color: #555;
            font-style: italic;
        }

        /* Kolom no dan days diberi lebar */
        th.no, td.no {
            width: 40px;
            text-align: center;
        }
        th.days, td.days {
            width: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
<table style="width: 100%; margin-bottom: 10px; border: none;">
    <tr>
        <td style="width: 60px; border: none;">
            <img src="{{ public_path('frontend/images/upi-logo.png') }}" alt="Logo" height="60" style="display: block;">
        </td>
        <td style="text-align: left; vertical-align: middle; border: none;">
            <p style="margin: 0; font-size: 16px;"><strong>PT. Ume Persada Indonesia</strong></p>
            <p style="margin: 0; font-size: 12px;">Comprehensive Plant Maintenance Services</p>
            <p style="margin: 0; font-size: 12px;">Jl. Raya Meduran No. 179, Roomo, Manyar Gresik 61151, Jawa Timur</p>
        </td>
    </tr>
</table>
<hr style="border: 0; border-top: 2px solid #000; margin-bottom: 20px;">
    <h2>Laporan Cuti Karyawan</h2>
    <p class="info">
        @if($start_date && $end_date)
            Periode: <strong>{{ $start_date }} sampai {{ $end_date }}</strong><br>
        @elseif($start_date)
            Dari tanggal: <strong>{{ $start_date }}</strong><br>
        @elseif($end_date)
            Sampai tanggal: <strong>{{ $end_date }}</strong><br>
        @endif

        @if($departmentName)
            <strong>{{ $departmentName }}</strong>
        @else
            Departemen: <strong>Semua</strong>
        @endif

        <strong>Dalam periode ini ada {{ $data->count() }} orang yang cuti.</strong>
    </p>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th>User</th>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th class="days">Days</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td class="no">{{$loop->iteration}}</td>
                <td>{{$item->user->name . ' ' . $item->user->last_name}}</td>
                <td>{{$item->leavetype->leave_type}}</td>
                <td>{{$item->leave_from}}</td>
                <td>{{$item->leave_to}}</td>
                <td class="
                    @switch($item->status)
                        @case(0) status-pending @break
                        @case(1) status-approved @break
                        @case(2) status-rejected @break
                        @default status-unknown
                    @endswitch
                ">
                    @switch($item->status)
                        @case(0) Pending @break
                        @case(1) Approved @break
                        @case(2) Rejected @break
                        @default Unknown
                    @endswitch
                </td>
                <td class="days">{{ $item->leave_days }}</td>
                <td>{{ $item->description }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;">Total Cuti (Hari)</th>
            <th class="days">{{ $data->sum('leave_days') }}</th>
            <th></th>
        </tr>
    </tfoot>
    </table>
</body>
</html>
