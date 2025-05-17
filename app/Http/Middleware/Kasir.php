<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Kasir
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5){
            return redirect()->route('dashboard.index')->withNotifyerror('You are unauthorized to access this resources');
        }

        return $next($request);
    }
}
