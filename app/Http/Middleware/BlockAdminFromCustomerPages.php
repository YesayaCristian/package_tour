<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockAdminFromCustomerPages
{
    /**
     * Jika user sudah login dan role = admin -> redirect ke admin dashboard.
     * Jika guest atau customer -> lanjut.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
