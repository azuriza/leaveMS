<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Applyleave;
use App\Models\User;
use App\Models\Department;  
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function indexleave(Request $request)
    {
        $query = Applyleave::with(['user.department', 'leavetype']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('leave_from', [$request->start_date, $request->end_date]);
        }

        if ($request->department) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $data = $query->get();
        $departments = Department::all();

        return view('admin.laporanleave.index', compact('data', 'departments'));
    }

    public function cetakPDFleave(Request $request)
    {
        $query = Applyleave::with(['user.department', 'leavetype']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('leave_from', [$request->start_date, $request->end_date]);
        }

        if ($request->department) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        if ($request->search) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->whereHas('user', function($q2) use ($keyword) {
                    $q2->where('name', 'like', "%$keyword%")
                    ->orWhere('last_name', 'like', "%$keyword%");
                })
                ->orWhereHas('leavetype', function($q3) use ($keyword) {
                    $q3->where('leave_type', 'like', "%$keyword%");
                })
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('leave_from', 'like', "%$keyword%")
                ->orWhere('leave_to', 'like', "%$keyword%");
            });
        }

        $data = $query->get();

        $start_date_text = date('j F Y', strtotime($request->start_date));
        $end_date_text = date('j F Y', strtotime($request->end_date));

         // Ambil nama departemen
        $departmentName = null;
        if ($request->department) {
            $dept = Department::find($request->department);
            $departmentName = $dept ? $dept->dpname : null;
        }

         // Kirim data + filter ke view
        $pdf = Pdf::loadView('admin.laporanleave.print', [
            'data' => $data,
            // 'start_date' => $request->start_date,
            // 'end_date' => $request->end_date,
            'start_date' => $start_date_text,
            'end_date' => $end_date_text,
            'departmentName' => $departmentName,
        ]);
        return $pdf->stream('laporan_applyleave.pdf');
    }

    //adminHR
    public function indexleaveadminhr(Request $request)
    {
        $query = Applyleave::with(['user.department', 'leavetype']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('leave_from', [$request->start_date, $request->end_date]);
        }

        if ($request->department) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $data = $query->get();
        $departments = Department::all();

        return view('adminhr.laporanleave.index', compact('data', 'departments'));
    }

    public function cetakPDFleaveadminhr(Request $request)
    {
        $query = Applyleave::with(['user.department', 'leavetype']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('leave_from', [$request->start_date, $request->end_date]);
        }

        if ($request->department) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        if ($request->search) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->whereHas('user', function($q2) use ($keyword) {
                    $q2->where('name', 'like', "%$keyword%")
                    ->orWhere('last_name', 'like', "%$keyword%");
                })
                ->orWhereHas('leavetype', function($q3) use ($keyword) {
                    $q3->where('leave_type', 'like', "%$keyword%");
                })
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('leave_from', 'like', "%$keyword%")
                ->orWhere('leave_to', 'like', "%$keyword%");
            });
        }

        $data = $query->get();

        $start_date_text = date('j F Y', strtotime($request->start_date));
        $end_date_text = date('j F Y', strtotime($request->end_date));

         // Ambil nama departemen
        $departmentName = null;
        if ($request->department) {
            $dept = Department::find($request->department);
            $departmentName = $dept ? $dept->dpname : null;
        }

         // Kirim data + filter ke view
        $pdf = Pdf::loadView('adminhr.laporanleave.print', [
            'data' => $data,
            // 'start_date' => $request->start_date,
            // 'end_date' => $request->end_date,
            'start_date' => $start_date_text,
            'end_date' => $end_date_text,
            'departmentName' => $departmentName,
        ]);
        return $pdf->stream('laporan_applyleave.pdf');
    }

    
}
