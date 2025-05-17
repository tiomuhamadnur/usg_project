<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAssigned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role_id == null){
            return redirect()->route('unassigned.user')->withNotifyerror('Akun anda belum diaktivasi, silahkan hubungi Admin.');
        }

        return $next($request);
    }
}
