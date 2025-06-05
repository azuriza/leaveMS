<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applyleave;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function cetakPDF()
    {
        $applyleave = Applyleave::all(); // ambil data dari DB
        $pdf = Pdf::loadView('laporan.karyawan', compact('karyawans'));
        return $pdf->download('laporan_karyawan.pdf'); // download langsung
    }
}
