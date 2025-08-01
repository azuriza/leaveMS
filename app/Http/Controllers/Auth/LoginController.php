<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    public function authenticated()
    {
        if (Auth::user()->role_as == '1') {
            return redirect('admin/dashboard')->with(['status' => ' Welcome to Admin Dashboard', 'status_code' => 'success']);
        } else if (Auth::user()->role_as == '2') {
            return redirect('manager/dashboard')->with(['status' => ' Welcome to Manager Dashboard', 'status_code' => 'success']);
        } else if (Auth::user()->role_as == '3') {
            return redirect('direktur/dashboard')->with(['status' => ' Welcome to Direktur Dashboard', 'status_code' => 'success']);
        } else if (Auth::user()->role_as == '4') {
            return redirect('adminhr/dashboard')->with(['status' => ' Welcome to Admin HR Dashboard', 'status_code' => 'success']);
        } else if (Auth::user()->role_as == '5') {
            return redirect('adminiso/dashboard')->with(['status' => ' Welcome to Admin ISO Dashboard', 'status_code' => 'success']);
        } else if (Auth::user()->role_as == '0') {
            return redirect('/dashboard')->with(['status' => ' Logged In Successful', 'status_code' => 'success']);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone' => $request->get('email'), 'password' => $request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
}

