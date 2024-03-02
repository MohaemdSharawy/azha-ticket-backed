<?php

namespace App\Http\Middleware;

use App\Events\ActiveUserEvent;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            User::where('id', Auth::id())->update(['login' => 1]);
            // ActiveUserEvent::dispatch();
        }

        return $next($request);
    }
}
