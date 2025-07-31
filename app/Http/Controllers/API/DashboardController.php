<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applyleave;
use App\Models\Department;
use App\Models\Leavetype;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{    
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

        if (!is_null($departments) && !is_null($leavetypes) && !is_null($leaves)) {
            return response()->json([
                'departments' => $departments,
                'leavetypes' => $leavetypes,
                'leaves' => $leaves,
                'users' => $users,
                'managers' => $managers,
                'admins' => $admins,
                'sisa_cuti' => $sisaCuti,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data dashboard, coba lagi atau hubungi admin.',
            ], 404);
        }

    }
}
