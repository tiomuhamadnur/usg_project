<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isBanned()) {
                Auth::logout();
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Akun Anda telah diblokir.',
                    ]);
            }
        }

        return $next($request);
    }
}
