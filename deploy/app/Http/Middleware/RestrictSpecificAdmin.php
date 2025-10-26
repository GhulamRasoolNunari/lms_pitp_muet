<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictSpecificAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // List of blocked emails
        $blockedEmails = [
           
        ];

        if ($user && in_array($user->email, $blockedEmails)) {
            // Abort with 404 (or any other response you prefer)
            abort(404);
            // Or alternatively:
            // return redirect()->route('home')->with('error', 'You are not allowed to access this page.');
        }

        return $next($request);
    }
}
