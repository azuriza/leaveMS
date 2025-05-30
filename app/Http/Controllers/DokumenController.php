<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::where('user_id', Auth::id())->get();
        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('file')->store('dokumen', 'public');

        Dokumen::create([
            'judul' => $request->judul,
            'file_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupload');
    }
}
