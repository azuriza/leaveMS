<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokumen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function show()
    {
        $dokumens = Dokumen::all();
        return view('Pages.dokumen.show', compact('dokumens'));
    }

    public function index()
    {
        $dokumens = Dokumen::where('user_id', Auth::id())->get();
        return view('adminiso.dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('adminiso.dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'file_path' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('file_path')->store('dokumen', 'public');

        $dokumen = new Dokumen;
        $dokumen->judul = $request->input('judul');
        $dokumen->file_path = $path;
        $dokumen->user_id = Auth::id();
        $dokumen->save();

        return redirect('adminiso/dokumen')->with(['status' => 'Document Added Successfully', 'status_code' => 'success']);
    }

    public function edit($id)
    {
        $dokumen = Dokumen::find($id);
        return view('adminiso.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'file_path' => 'nullable|mimes:pdf|max:2048',  // file_path boleh kosong saat update
        ]);

        $dokumen = Dokumen::findOrFail($id);
        $dokumen->judul = $request->input('judul');
        $dokumen->user_id = Auth::id();

        // Cek jika ada file baru diupload
        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($dokumen->file_path && \Storage::disk('public')->exists($dokumen->file_path)) {
                \Storage::disk('public')->delete($dokumen->file_path);
            }

            // Simpan file baru
            $path = $request->file('file_path')->store('dokumen', 'public');
            $dokumen->file_path = $path;
        }

        $dokumen->save();

        return redirect('adminiso/dokumen')->with(['status' => 'Document updated successfully', 'status_code' => 'success']);

    }
    
    public function delete($id)
    {
        $dokumen = Dokumen::find($id);
        $dokumen->delete();
        return redirect('adminiso/dokumen')->with(['status' => 'Document deleted successfully', 'status_code' => 'success']);
    }
}
