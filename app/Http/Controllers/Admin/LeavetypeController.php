<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leavetype;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LeavetypeController extends Controller
{
    public function index()
    {
        $leavetype = Leavetype::all();  // declare and import
        return view('admin.leavetype.index', compact('leavetype'));
    }
    public function create()
    {
        return view('admin.leavetype.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|unique:leavetypes,leave_type',
            'description' => ['nullable', 'string'],
        ]);
        $leavetype = new Leavetype;
        $leavetype->leave_type = $request->input('leave_type');
        $leavetype->description = $request->input('description');
        $leavetype->save();

        return redirect('admin/leavetype')->with(['status' => 'Leave Type Added Successfully', 'status_code' => 'success']);
    }
    public function edit($id)
    {
        $leavetype = Leavetype::find($id);
        return view('admin.leavetype.edit', compact('leavetype'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'leave_type' => 'required|unique:leavetypes,leave_type,' . $id,
            'description' => ['nullable', 'string'],
            'status' => 'required'
        ]);
        $leavetype = Leavetype::find($id);
        $leavetype->leave_type = $request->input('leave_type');
        $leavetype->description = $request->input('description');
        $leavetype->status = $request->input('status') == true ? '1' : '0';
        $leavetype->update();

        return redirect('admin/leavetype')->with(['status' => 'Leave-type updated successfully', 'status_code' => 'success']);
    }
    public function delete($id)
    {
        $leavetype = Leavetype::find($id);
        $leavetype->delete();
        return redirect('admin/leavetype')->with(['status' => 'Leave-type deleted successfully', 'status_code' => 'success']);
    }
}
