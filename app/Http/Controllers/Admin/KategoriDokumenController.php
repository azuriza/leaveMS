<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriDokumen;
use Illuminate\Http\Request;

class KategoriDokumenController extends Controller
{
    public function indexadmin()
    {
        $kategori = KategoriDokumen::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function createadmin()
    {
        return view('admin.kategori.create');
    }

    public function storeadmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriDokumen::create([
            'nama' => $request->nama,
        ]);

        return redirect('admin/kategori')->with(['status' => 'Category Document Added Successfully', 'status_code' => 'success']);
    }

    public function showadmin($id)
    {
        //
    }

    public function editadmin($id)
    {
        $kategori = KategoriDokumen::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function updateadmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = KategoriDokumen::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect('admin/kategori')->with(['status' => 'Category Document updated successfully', 'status_code' => 'success']);
    }

    public function deleteadmin($id)
    {
        $kategori = KategoriDokumen::findOrFail($id);
        $kategori->delete();

        return redirect('admin/kategori')->with(['status' => 'Category Document deleted successfully', 'status_code' => 'success']);
    }

    //adminISO
    public function index()
    {
        $kategori = KategoriDokumen::all();
        return view('adminiso.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('adminiso.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriDokumen::create([
            'nama' => $request->nama,
        ]);

        return redirect('adminiso/kategori')->with(['status' => 'Category Document Added Successfully', 'status_code' => 'success']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kategori = KategoriDokumen::findOrFail($id);
        return view('adminiso.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = KategoriDokumen::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect('adminiso/kategori')->with(['status' => 'Category Document updated successfully', 'status_code' => 'success']);
    }

    public function delete($id)
    {
        $kategori = KategoriDokumen::findOrFail($id);
        $kategori->delete();

        return redirect('adminiso/kategori')->with(['status' => 'Category Document deleted successfully', 'status_code' => 'success']);
    }
}
