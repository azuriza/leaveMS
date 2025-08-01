<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applyleave;
use App\Models\Leavetype;
use App\Models\User;
use App\Models\Department;
use App\Models\LeaveBalance;
use App\Helpers\DateHelper;
use App\Notifications\CutiDisetujuiNotification;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApplyleaveController extends Controller
{
    public function index()
    {
        //$user_id = Auth::user()->id;
        $dep = Auth::user()->department_id;
        $data = Applyleave::whereHas('User', function($query) use ($dep) {
            $query->where('department_id', $dep);
        })->with(['User.department'])->get();
        //$data = Applyleave::all();
        return view('admin.Applyleave.index', compact('data'));
    }
    
    public function _create() // applies on backend
    {
        $users = User::all();
        $leavetype = Leavetype::all();
        return view('admin.Applyleave.create', ['users' => $users], ['leavetype' => $leavetype]);
    }

    public function register(Request $request) // Store function for backend
    {
        $request->validate([
            'user_id' => 'required',
            'leave_type_id' => 'required',
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required'
        ]);

        $data = new Applyleave;
        $data->user_id = $request->input('user_id');
        $data->leave_type_id = $request->input('leave_type_id');
        $data->description = $request->input('description');
        $data->leave_from = $request->input('leave_from');
        $data->leave_to = $request->input('leave_to');
        $data->save();

        return redirect('admin/applyleave')->with(['status' => 'Leave Applied Successfully', 'status_code' => 'success']);
    }    

    public function edit($id)// Backend
    {
        $data = Applyleave::find($id);
        return view('admin.Applyleave.edit', compact('data'));
    }  

    public function update(Request $request, $id) // backend
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails())
        {
           $errors = implode(" ", $validator->errors()->all());
           return response(['status' => 'error', 'message' => $errors]);
        }

         $data = Applyleave::findOrFail($id);
         if(($data->status) === 1)
           {
            return redirect('admin/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']);  
           }
           else
           {
            if ($data) {
                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->status = $request->input('status');
                $data->update();

                return redirect('admin/applyleave')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);
            }
            else
            {
                return redirect('admin/add/applyleave')->with(['status' => 'something went wrong! Contact administrator', 'status_code' => 'error']);   
            }
        }       
    }    

    public function delete($id)
    {
        $data = Applyleave::find($id);
        $data->delete();
        return redirect('admin/applyleave')->with(['status' => 'Deleted Successfully', 'status_code' => 'success']);
    }
    
    //implementation adminhr
    public function indexadminhrself()
    {
        $data = Applyleave::whereNotIn('leave_type_id', [8, 9])->get();
        return view('adminhr.Applyleave.indexself', compact('data'));
    }

    public function indexadminhr()
    {
        $data = Applyleave::whereIn('leave_type_id', [8, 9])->get();
        return view('adminhr.Applyleave.index', compact('data'));
    }

    public function editadminhr($id)// Backend
    {
        $users = User::all();
        $data = Applyleave::find($id);
        $isOwnData = $data->user_id == Auth::user()->id;
        
        return view('adminhr.Applyleave.edit', compact('data','users','isOwnData'));
    } 

    public function updateadminhr(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'status' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reason' => 'nullable'
        ]);

        if ($validator->fails())
        {
           $errors = implode(" ", $validator->errors()->all());
           return response(['status' => 'error', 'message' => $errors]);
        }

         $data = Applyleave::findOrFail($id);
         if(($data->status) === 1)
           {
            return redirect('adminhr/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']);  
           }
           else
           {
            if ($data) {

                $user = auth()->user();
                $tahunIni = now()->year;
                $leavetype = $request->input('leave_type_id');

                $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
                $sisaCuti = $balance ? $balance->sisa_cuti : 0;

                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
                    // Validasi logika sisa cuti
                    if ($sisaCuti < $request->input('leave_days')) {
                        return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
                    }
                }

                // 1. Hitung jumlah hari lama
                $jumlahHariLama = $data->leave_days;
                $jumlahHariBaru = $request->input('leave_days');
                $statuslama = $data->status;
                $statusbaru = $request->input('status');

                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->status = $request->input('status');
                $data->handover_id = $request->input('handover_id');
                $data->handover_id_2 = $request->input('handover_id_2');
                $data->handover_id_3 = $request->input('handover_id_3');
                $data->leave_days = $request->input('leave_days');

                // Cek jika ada file baru diupload
                if ($request->hasFile('file_path')) {
                    // Hapus file lama jika ada
                    if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                        \Storage::disk('public')->delete($data->file_path);
                    }

                    // Simpan file baru
                    $path = $request->file('file_path')->store('dokumencuti', 'public');
                    $data->file_path = $path;
                }
                $data->reason = $request->input('reason');
                $data->update();

                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate 
                    // 4. Hitung selisih dan update leave_balances
                    $selisih = $jumlahHariBaru - $jumlahHariLama;
                    $tahun = now()->year;

                    $balance = LeaveBalance::where('user_id', $data->user_id)
                        ->where('tahun', $tahun)
                        ->first();

                    if ($balance && $selisih !== 0) {
                        if ($selisih > 0) {
                            $balance->increment('cuti_terpakai', $selisih);
                        } else {
                            $balance->decrement('cuti_terpakai', abs($selisih));
                        }
                    }

                    if ($statuslama !== 2 && $statusbaru === 2){
                        $balance->decrement('cuti_terpakai', abs($jumlahHariBaru));    
                    }

                    if ($statuslama === 2 && ($statusbaru === 1 || $statusbaru === 0)) {
                        $balance->increment('cuti_terpakai', $jumlahHariBaru);  
                    }  
                }            


                return redirect('adminhr/applyleave')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);                  
            }
            else
            {
                return redirect('adminhr/add/applyleave')->with(['status' => 'something went wrong! Contact administrator', 'status_code' => 'error']);   
            }
        }       
    }  

    //implementation direktur
    public function indexdirekturself()
    {
        $user_id = Auth::user()->id;
        $data = Applyleave::where('user_id', $user_id)->get();
        return view('direktur.Applyleave.indexself', compact('data'));
    }

    public function indexdirektur()
    {
        //$user_id = Auth::user()->id;
        $data = Applyleave::whereHas('User', function($query) {
            $query->where('role_as', 2);
        })
        ->get();
        //$data = Applyleave::all();
        return view('direktur.Applyleave.index', compact('data'));
    }
    
    public function _createdirektur() 
    {
        $users = User::all();
        $leavetype = Leavetype::all();
        $user = auth()->user();
        $tahunIni = now()->year;

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;
        return view('direktur.Applyleave.create', [
            'users' => $users,
            'leavetype' => $leavetype,
            'sisaCuti' => $sisaCuti
        ]);
    }

    public function registerdirektur(Request $request) 
    {
        $request->validate([
            'user_id' => 'required',
            'leave_type_id' => 'required',
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reason' => 'nullable'
        ]);

        $user = auth()->user();
        $tahunIni = now()->year;
        $leavetype = $request->input('leave_type_id');

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;

        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
            // Validasi logika sisa cuti
            if ($sisaCuti < $request->input('leave_days')) {
                return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
            }
        }

        $data = new Applyleave;
        $data->user_id = $request->input('user_id');
        $data->leave_type_id = $request->input('leave_type_id');
        $data->description = $request->input('description');
        $data->leave_from = $request->input('leave_from');
        $data->leave_to = $request->input('leave_to');
        $data->handover_id = $request->input('handover_id');
        $data->handover_id_2 = $request->input('handover_id_2');
        $data->handover_id_3 = $request->input('handover_id_3');
        $data->leave_days = $request->input('leave_days');
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('dokumencuti', 'public');
            $data->file_path = $path; // jika ingin disimpan ke database
        }
        $data->reason = $request->input('reason');
        $data->save();

        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
            $jumlahHari = $request->input('leave_days'); 

            // 2. Update cuti_terpakai di leave_balances
            $tahun = now()->year;

            $balance = LeaveBalance::where('user_id', $request->user_id)
                ->where('tahun', $tahun)
                ->first();

            if ($balance) {
                $balance->increment('cuti_terpakai', $jumlahHari);
            }
        }

        return redirect('direktur/applyleaveself')->with(['status' => 'Leave Applied Successfully', 'status_code' => 'success']);
    }    

    public function editdirektur($id)
    {
        $users = User::all();
        $data = Applyleave::find($id);
        $isOwnData = $data->user_id == Auth::user()->id;
        
        return view('direktur.Applyleave.edit', compact('data','users','isOwnData'));
    }  

    public function updatedirektur(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'status' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reason' => 'nullable'
        ]);

        if ($validator->fails())
        {
           $errors = implode(" ", $validator->errors()->all());
           return response(['status' => 'error', 'message' => $errors]);
        }

         $data = Applyleave::findOrFail($id);
         $userlogin = Auth::user()->id;
         if(($data->status) === 1)
           {
            if ($data->user_id === $userlogin) {
                return redirect('direktur/applyleaveself')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']); 
            } else {
                return redirect('direktur/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']); 
            } 
           }
           else
           {
            if ($data) {
                $user = auth()->user();
                $tahunIni = now()->year;
                $leavetype = $request->input('leave_type_id');

                $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
                $sisaCuti = $balance ? $balance->sisa_cuti : 0;

                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
                    // Validasi logika sisa cuti
                    if ($sisaCuti < $request->input('leave_days')) {
                        return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
                    }
                }

                // 1. Hitung jumlah hari lama
                $jumlahHariLama = $data->leave_days;
                $jumlahHariBaru = $request->input('leave_days');
                $statuslama = $data->status;
                $statusbaru = $request->input('status');

                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->status = $request->input('status');
                $data->handover_id = $request->input('handover_id');
                $data->handover_id_2 = $request->input('handover_id_2');
                $data->handover_id_3 = $request->input('handover_id_3');
                $data->leave_days = $request->input('leave_days');

                // Cek jika ada file baru diupload
                if ($request->hasFile('file_path')) {
                    // Hapus file lama jika ada
                    if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                        \Storage::disk('public')->delete($data->file_path);
                    }

                    // Simpan file baru
                    $path = $request->file('file_path')->store('dokumencuti', 'public');
                    $data->file_path = $path;
                }
                $data->reason = $request->input('reason');
                $data->update();

                if ($leavetype !== '8' && $leavetype !== '9') { // Sick or Compassionate 
                    // 4. Hitung selisih dan update leave_balances
                    $selisih = $jumlahHariBaru - $jumlahHariLama;
                    $tahun = now()->year;

                    $balance = LeaveBalance::where('user_id', $data->user_id)
                        ->where('tahun', $tahun)
                        ->first();

                    if ($balance && $selisih !== 0) {
                        if ($selisih > 0) {
                            $balance->increment('cuti_terpakai', $selisih);
                        } else {
                            $balance->decrement('cuti_terpakai', abs($selisih));
                        }
                    }

                    if ($statuslama !== 2 && $statusbaru === 2){
                        $balance->decrement('cuti_terpakai', abs($jumlahHariBaru));    
                    }

                    if ($statuslama === 2 && ($statusbaru === 1 || $statusbaru === 0)) {
                        $balance->increment('cuti_terpakai', $jumlahHariBaru);  
                    }  
                }            

                if ($data->user_id === $userlogin) {
                    return redirect('direktur/applyleaveself')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);
                } else {
                    return redirect('direktur/applyleave')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);  
                }
                
            }
            else
            {
                return redirect('direktur/add/applyleave')->with(['status' => 'something went wrong! Contact administrator', 'status_code' => 'error']);   
            }
        }       
    }    

    public function deletedirektur($id)
    {
        $data = Applyleave::find($id);
        $data->delete();
        return redirect('manager/applyleave')->with(['status' => 'Deleted Successfully', 'status_code' => 'success']);
    }

    //implementation manager
    public function indexmanagerself()
    {
        $user_id = Auth::user()->id;
        $data = Applyleave::where('user_id', $user_id)->get();
        return view('manager.Applyleave.indexself', compact('data'));
    }

    public function indexmanager()
    {
        //$user_id = Auth::user()->id;
        $dep = Auth::user()->department_id;
        $data = Applyleave::whereHas('User', function($query) use ($dep) {
            $query->where('department_id', $dep)->where('role_as', 0);
        })->with(['User.department'])
        ->get();
        //$data = Applyleave::all();
        return view('manager.Applyleave.index', compact('data'));
    }
    
    public function _createmanager() 
    {
        $users = User::all();
        $leavetype = Leavetype::all();
        $user = auth()->user();
        $tahunIni = now()->year;

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;
        return view('manager.Applyleave.create', [
            'users' => $users,
            'leavetype' => $leavetype,
            'sisaCuti' => $sisaCuti
        ]);
    }

    public function registermanager(Request $request) 
    {
        $request->validate([
            'user_id' => 'required',
            'leave_type_id' => 'required',
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reason' => 'nullable'
        ]);

        $user = auth()->user();
        $tahunIni = now()->year;
        $leavetype = $request->input('leave_type_id');

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;

        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
            // Validasi logika sisa cuti
            if ($sisaCuti < $request->input('leave_days')) {
                return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
            }
        }

        $data = new Applyleave;
        $data->user_id = $request->input('user_id');
        $data->leave_type_id = $request->input('leave_type_id');
        $data->description = $request->input('description');
        $data->leave_from = $request->input('leave_from');
        $data->leave_to = $request->input('leave_to');
        $data->handover_id = $request->input('handover_id');
        $data->handover_id_2 = $request->input('handover_id_2');
        $data->handover_id_3 = $request->input('handover_id_3');
        $data->leave_days = $request->input('leave_days');
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('dokumencuti', 'public');
            $data->file_path = $path; // jika ingin disimpan ke database
        }
        $data->reason = $request->input('reason');
        $data->save();

        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
            $jumlahHari = $request->input('leave_days'); 

            // 2. Update cuti_terpakai di leave_balances
            $tahun = now()->year;

            $balance = LeaveBalance::where('user_id', $request->user_id)
                ->where('tahun', $tahun)
                ->first();

            if ($balance) {
                $balance->increment('cuti_terpakai', $jumlahHari);
            }
        }

        return redirect('manager/applyleaveself')->with(['status' => 'Leave Applied Successfully', 'status_code' => 'success']);
    }    

    public function editmanager($id)
    {
        $users = User::all();
        $data = Applyleave::find($id);
        $isOwnData = $data->user_id == Auth::user()->id;
        
        return view('manager.Applyleave.edit', compact('data','users','isOwnData'));
    }  

    public function updatemanager(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'status' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'reason' => 'nullable'
        ]);

        if ($validator->fails())
        {
           $errors = implode(" ", $validator->errors()->all());
           return response(['status' => 'error', 'message' => $errors]);
        }

         $data = Applyleave::findOrFail($id);
         $userlogin = Auth::user()->id;
         if(($data->status) === 1)
           {
            if ($data->user_id === $userlogin) {
                return redirect('manager/applyleaveself')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']); 
            } else {
                return redirect('manager/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']); 
            } 
           }
           else
           {
            if ($data) {
                $user = auth()->user();
                $tahunIni = now()->year;
                $leavetype = $request->input('leave_type_id');

                $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
                $sisaCuti = $balance ? $balance->sisa_cuti : 0;

                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
                    // Validasi logika sisa cuti
                    if ($sisaCuti < $request->input('leave_days')) {
                        return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
                    }
                }

                // 1. Hitung jumlah hari lama
                $jumlahHariLama = $data->leave_days;
                $jumlahHariBaru = $request->input('leave_days');
                $statuslama = $data->status;
                $statusbaru = $request->input('status');

                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->status = $request->input('status');
                $data->handover_id = $request->input('handover_id');
                $data->handover_id_2 = $request->input('handover_id_2');
                $data->handover_id_3 = $request->input('handover_id_3');
                $data->leave_days = $request->input('leave_days');

                // Cek jika ada file baru diupload
                if ($request->hasFile('file_path')) {
                    // Hapus file lama jika ada
                    if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                        \Storage::disk('public')->delete($data->file_path);
                    }

                    // Simpan file baru
                    $path = $request->file('file_path')->store('dokumencuti', 'public');
                    $data->file_path = $path;
                }
                $data->reason = $request->input('reason');
                $data->update();

                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate 
                    // 4. Hitung selisih dan update leave_balances
                    $selisih = $jumlahHariBaru - $jumlahHariLama;
                    $tahun = now()->year;

                    $balance = LeaveBalance::where('user_id', $data->user_id)
                        ->where('tahun', $tahun)
                        ->first();

                    if ($balance && $selisih !== 0) {
                        if ($selisih > 0) {
                            $balance->increment('cuti_terpakai', $selisih);
                        } else {
                            $balance->decrement('cuti_terpakai', abs($selisih));
                        }
                    }

                    if ($statuslama !== 2 && $statusbaru === 2){
                        $balance->decrement('cuti_terpakai', abs($jumlahHariBaru));    
                    }

                    if ($statuslama === 2 && ($statusbaru === 1 || $statusbaru === 0)) {
                        $balance->increment('cuti_terpakai', $jumlahHariBaru);  
                    }  
                }       
                
                // Kirim notifikasi jika status berpindah ke disetujui
                if ($statuslama !== 1 && $statusbaru == 1) {
                    $data->user->notify(new CutiDisetujuiNotification($data));
                }

                if ($data->user_id === $userlogin) {
                    return redirect('manager/applyleaveself')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);
                } else {
                    return redirect('manager/applyleave')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);  
                }
                
            }
            else
            {
                return redirect('manager/add/applyleave')->with(['status' => 'something went wrong! Contact administrator', 'status_code' => 'error']);   
            }
        }       
    }    

    public function deletemanager($id)
    {
        $data = Applyleave::find($id);
        $data->delete();
        return redirect('manager/applyleave')->with(['status' => 'Deleted Successfully', 'status_code' => 'success']);
    }

    //implementation employee
    public function create() // applies on fronted
    {
        //$users = User::all();
        $users = User::where('department_id', auth()->user()->department_id)
                    ->where('role_as', 0)            
                    ->get();
        $leavetype = Leavetype::all();

        $user = auth()->user();
        $tahunIni = now()->year;

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;

        return view('Pages.Applyleave.create', [
            'users' => $users,
            'leavetype' => $leavetype,
            'sisaCuti' => $sisaCuti
        ]);

    }

    public function store(Request $request) // store in frontend
    {
        $request->validate([
            'user_id' => 'required',
            'leave_type_id' => 'required',
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();
        $tahunIni = now()->year;
        $leavetype = $request->input('leave_type_id');

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;

         // Validasi logika sisa cuti
        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') {
            if ($sisaCuti < $request->input('leave_days')) {
                return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
            }
        }

        $data = new Applyleave;
        $data->user_id = $request->input('user_id');
        $data->leave_type_id = $request->input('leave_type_id');
        $data->description = $request->input('description');
        $data->leave_from = $request->input('leave_from');
        $data->leave_to = $request->input('leave_to');
        $data->handover_id = $request->input('handover_id');
        $data->handover_id_2 = $request->input('handover_id_2');
        $data->handover_id_3 = $request->input('handover_id_3');
        $data->leave_days = $request->input('leave_days');
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('dokumencuti', 'public');
            $data->file_path = $path; // jika ingin disimpan ke database
        }
        $data->save();

        if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') {
            //$jumlahHari = DateHelper::getWorkdays($request->input('leave_from'), $request->input('leave_to'));
            $jumlahHari = $request->input('leave_days'); 

            // 2. Update cuti_terpakai di leave_balances
            $tahun = now()->year;
            $balance = LeaveBalance::where('user_id', $request->user_id)
                ->where('tahun', $tahun)
                ->first();

            if ($balance) {
                $balance->increment('cuti_terpakai', $jumlahHari);
            }
        }

        // return redirect('add/applyleave')->with(['status' => 'Leave Applied Successfully. You have 2 days to update your application', 'status_code' => 'success']);
        return redirect('add/applyleave')->with(['status' => 'Leave Applied Successfully.', 'status_code' => 'success']);
    }
    
    public function show()
    {
        $data = Applyleave::all();
        return view('Pages.Applyleave.show', compact('data'));
    }

    public function showho()
    {
        $userId = Auth::id();
        $data = \App\Models\Applyleave::select('*')
            ->selectRaw("CASE
                WHEN handover_id = ? and handover_status = 1 THEN 1
                WHEN handover_id = ? and handover_status = 2 THEN 2
                WHEN handover_id_2 = ? and handover2_status = 1 THEN 1
                WHEN handover_id_2 = ? and handover2_status = 2 THEN 2
                WHEN handover_id_3 = ? and handover3_status = 1 THEN 1
                WHEN handover_id_3 = ? and handover3_status = 2 THEN 2
                ELSE 0
            END as handover_match", [
                $userId, $userId, $userId, $userId, $userId, $userId
            ])
            ->where(function ($q) use ($userId) {
                $q->where('handover_id', $userId)
                ->orWhere('handover_id_2', $userId)
                ->orWhere('handover_id_3', $userId);
            })
            ->with('User')
            ->get();

        return view('Pages.Applyleave.showho', compact('data'));
    }

    public function accept($id)
    {
        $leave = Applyleave::findOrFail($id);

        // Tandai status sebagai diterima oleh yang sedang login
        if (Auth::id() == $leave->handover_id) {
            $leave->handover_status = 1;
        } elseif (Auth::id() == $leave->handover_id_2) {
            $leave->handover2_status = 1;
        } elseif (Auth::id() == $leave->handover_id_3) {
            $leave->handover3_status = 1;
        }

        $leave->save();

        return redirect()->back()->with('success', 'Hand Over accepted.');
    }

    public function reject($id)
    {
        $leave = Applyleave::findOrFail($id);

        if (Auth::id() == $leave->handover_id) {
            $leave->handover_status = 2;
        } elseif (Auth::id() == $leave->handover_id_2) {
            $leave->handover2_status = 2;
        } elseif (Auth::id() == $leave->handover_id_3) {
            $leave->handover3_status = 2;
        }

        $leave->save();

        return redirect()->back()->with('error', 'Hand Over rejected.');
    }
    
    public function _edit($id)// Frontend
    {
        $data = Applyleave::find($id);
        $users = User::where('department_id', auth()->user()->department_id)
                    ->where('role_as', 0)            
                    ->get();

        $user = auth()->user();
        $tahunIni = now()->year;

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;
        return view('Pages.Applyleave.edit', compact('data','users','sisaCuti'));
    }

    public function _update(Request $request, $id) // Update on the frontend
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'handover_id' => 'required',
            'handover_id_2' => 'nullable',
            'handover_id_3' => 'nullable',
            'leave_days' => 'required',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);
        
        if ($validator->fails()) {
            $errors = implode(" ", $validator->errors()->all());
            return response(['status' => 'error', 'message' => $errors]);
        }                                    

        $data = Applyleave::find($id);
        if(($data->status) === 1)
        {
            return redirect('show/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']);  
        } 
        else
        if(($data->status) === 0)
        {   
            $user = auth()->user();
            $tahunIni = now()->year;
            $leavetype = $request->input('leave_type_id');

            $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
            $sisaCuti = $balance ? $balance->sisa_cuti : 0;

            if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate
                // Validasi logika sisa cuti
                if ($sisaCuti < $request->input('leave_days')) {
                    return back()->withErrors(['msg' => 'Sisa cuti tidak mencukupi.'])->withInput();
                }
            }

            // 1. Hitung jumlah hari lama
            $jumlahHariLama = $data->leave_days;
            $jumlahHariBaru = $request->input('leave_days');

            if ($data) {
                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->handover_id = $request->input('handover_id');
                $data->handover_id_2 = $request->input('handover_id_2');
                $data->handover_id_3 = $request->input('handover_id_3');
                $data->leave_days = $request->input('leave_days');
                
                // Cek jika ada file baru diupload
                if ($request->hasFile('file_path')) {
                    // Hapus file lama jika ada
                    if ($data->file_path && \Storage::disk('public')->exists($data->file_path)) {
                        \Storage::disk('public')->delete($data->file_path);
                    }

                    // Simpan file baru
                    $path = $request->file('file_path')->store('dokumencuti', 'public');
                    $data->file_path = $path;
                }
                $data->update(); 
                
                if ($leavetype !== '8' && $leavetype !== '9' && $leavetype !== '12') { // Sick or Compassionate            
                    // 4. Hitung selisih dan update leave_balances
                    $selisih = $jumlahHariBaru - $jumlahHariLama;
                    $tahun = now()->year;

                    $balance = LeaveBalance::where('user_id', $data->user_id)
                        ->where('tahun', $tahun)
                        ->first();

                    if ($balance && $selisih !== 0) {
                        if ($selisih > 0) {
                            $balance->increment('cuti_terpakai', $selisih);
                        } else {
                            $balance->decrement('cuti_terpakai', abs($selisih));
                        }
                    }
                }
                        
                return redirect('show/applyleave')->with(['status' => 'Leave updated successfully and is being processed', 'status_code' => 'success']);
            } else {
                return redirect('add/applyleave')->with(['status' => 'error', 'message' => 'Technical error ocurred , contact administrator.']);
            }
        }

            // //declaring  values.
            // $fdata = $data->created_at ;
            // $account_active_days = 2;
    
            // // calculating the expiration date.
            // $account_expires = "{$fdata} + {$account_active_days} days";
    
            // // creating objects from the two dates.
            // $origin = new DateTime($fdata);
            // $expire = new Datetime($account_expires);
    
            // $today = new DateTime();
         
            // if ($expire < $today)
            //  {
            //   return redirect('/')->with(['status' => 'Your update time has expired!', 'status_code' => 'error']);
            //  }
            //  else
            //  {
                
           
            // }             
    }
}
