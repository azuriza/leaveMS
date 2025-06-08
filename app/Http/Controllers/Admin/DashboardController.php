<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applyleave;
use App\Models\Department;
use App\Models\Leavetype;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::count();
        $users = User::where('role_as', '0')->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();
        return view('admin.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers','admins'));
    }
    public function dashadminhr()
    {
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::count();
        $users = User::where('role_as', '0')->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();
        return view('adminhr.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers','admins'));
    }
    public function dashiso()
    {
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::count();
        $departmentOfLoggedInUser = Auth::user()->department_id;
        $users = User::where('role_as', '0')
                ->where('department_id', $departmentOfLoggedInUser)
                ->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();
        return view('adminiso.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers', 'admins'));
    }
    public function dashmanager()
    {
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::count();
        $departmentOfLoggedInUser = Auth::user()->department_id;
        $users = User::where('role_as', '0')
                ->where('department_id', $departmentOfLoggedInUser)
                ->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();
        return view('manager.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers', 'admins'));
    }

    public function dashdirektur()
    {
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::count();
        $departmentOfLoggedInUser = Auth::user()->department_id;
        $users = User::where('role_as', '0')
                ->where('department_id', $departmentOfLoggedInUser)
                ->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();
        return view('direktur.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers', 'admins'));
    }
    public function dashemployee()
    {
        $user_id = Auth::user()->id;
        $departments = Department::count();
        $leavetypes = Leavetype::count();
        $leaves = Applyleave::where('user_id', $user_id)->count();
        $users = User::where('role_as', '0')->count();
        $managers = User::where('role_as', '2')->count();
        $admins = User::where('role_as', '1')->count();

        $user = auth()->user();
        $tahunIni = now()->year;

        $balance = $user->leaveBalances()->where('tahun', $tahunIni)->first();
        $sisaCuti = $balance ? $balance->sisa_cuti : 0;

        return view('Pages.dashboard', compact('departments', 'leavetypes', 'leaves', 'users', 'managers', 'admins', 'sisaCuti'));
    }
}
