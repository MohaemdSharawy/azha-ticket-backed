<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('security-code')  && $request->header('security-code')  == 'tGGLLxRIKBR1dhdEavkUWQ6Fwd3G9inQZHz5hm2U') {
            return $next($request);
        } else {
            return response()->json([
                'message' => 'Your Request Not Secured Please Enter Valid Token '
            ], 403);
        }
    }
}
