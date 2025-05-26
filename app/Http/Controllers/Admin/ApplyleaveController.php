<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applyleave;
use App\Models\Leavetype;
use App\Models\User;
use App\Models\Department;
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
    
    //implementation manager
    public function indexmanager()
    {
        //$user_id = Auth::user()->id;
        $dep = Auth::user()->department_id;
        $data = Applyleave::whereHas('User', function($query) use ($dep) {
            $query->where('department_id', $dep);
        })->with(['User.department'])->get();
        //$data = Applyleave::all();
        return view('manager.Applyleave.index', compact('data'));
    }
    
    public function _createmanager() 
    {
        $users = User::all();
        $leavetype = Leavetype::all();
        return view('manager.Applyleave.create', ['users' => $users], ['leavetype' => $leavetype]);
    }

    public function registermanager(Request $request) 
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

        return redirect('manager/applyleave')->with(['status' => 'Leave Applied Successfully', 'status_code' => 'success']);
    }    

    public function editmanager($id)
    {
        $data = Applyleave::find($id);
        return view('manager.Applyleave.edit', compact('data'));
    }  

    public function updatemanager(Request $request, $id)
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
            return redirect('manager/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']);  
           }
           else
           {
            if ($data) {
                $data->description = $request->input('description');
                $data->leave_from = $request->input('leave_from');
                $data->leave_to = $request->input('leave_to');
                $data->status = $request->input('status');
                $data->update();

                return redirect('manager/applyleave')->with(['status' => 'Updated Successfully', 'status_code' => 'success']);
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
        $users = User::all();
        $leavetype = Leavetype::all();
        return view('Pages.Applyleave.create', ['users' => $users], ['leavetype' => $leavetype]);
    }

    public function store(Request $request) // store in frontend
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

        return redirect('add/applyleave')->with(['status' => 'Leave Applied Successfully. You have 2 days to update your application', 'status_code' => 'success']);
    }
    
    public function show()
    {
        $data = Applyleave::all();
        return view('Pages.Applyleave.show', compact('data'));
    }
    
    public function _edit($id)// Frontend
    {
        $data = Applyleave::find($id);
        return view('Pages.Applyleave.edit', compact('data'));
    }

    public function _update(Request $request, $id) // Update on the frontend
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = implode(" ", $validator->errors()->all());
            return response(['status' => 'error', 'message' => $errors]);
        }
                                    

            $data = Applyleave::find($id);
            // declaring  values.
            $fdata = $data->created_at ;
            $account_active_days = 2;
    
            // calculating the expiration date.
            $account_expires = "{$fdata} + {$account_active_days} days";
    
            // creating objects from the two dates.
            $origin = new DateTime($fdata);
            $expire = new Datetime($account_expires);
    
            $today = new DateTime();
         
            if ($expire < $today)
             {
              return redirect('/')->with(['status' => 'Your update time has expired!', 'status_code' => 'error']);
             }
             else
             {
                if(($data->status) === 1)
                {
                    return redirect('show/applyleave')->with(['status' => 'Accepted! You cannot update anymore!', 'status_code' => 'error']);  
                } 
                else
                if(($data->status) === 0)
                {          
                    if ($data) {
                        $data->description = $request->input('description');
                        $data->leave_from = $request->input('leave_from');
                        $data->leave_to = $request->input('leave_to');
                        $data->update();
        
                        return redirect('show/applyleave')->with(['status' => 'Leave updated successfully and is being processed', 'status_code' => 'success']);
                    } else {
                        return redirect('add/applyleave')->with(['status' => 'error', 'message' => 'Technical error ocurred , contact administrator.']);
                    }
               }
           
            }  
        
           
    }
}
