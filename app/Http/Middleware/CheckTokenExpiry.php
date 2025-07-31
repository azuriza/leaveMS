<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckTokenExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()?->currentAccessToken()?->expires_at &&
            Carbon::parse($request->user()->currentAccessToken()->expires_at)->isPast()) {
            
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Token expired, please login again.'
            ], 401);
        }

        return $next($request);
    }
}
