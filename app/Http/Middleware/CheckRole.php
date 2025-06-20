<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Konversi role parameter ke integer
        $requiredRole = (int) $role;
        if (Auth::check() && Auth::user()->role_as === $requiredRole) {
            return $next($request);
        }
      else 
    {
      return abort(403, 'Unauthorized action.'); // ✅ ubah di sini
      //return  redirect('/login')->with(['status'=>' Please login first!','status_code'=>'info']);
    }
    } 
}
