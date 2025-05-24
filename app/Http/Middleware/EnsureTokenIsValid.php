<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = '123e4567-e89b-12d3-a456-426614174000';
        $providedToken = $request->header('Authorization');

        if ($providedToken !== $token) {
            abort(401, 'token no válido.');
        }

        return $next($request);
    }
}
