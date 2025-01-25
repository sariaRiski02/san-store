<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $AuthorizationToken = $request->header('Authorization');


        // cek jika ada token dan token memiliki awalan bearer
        if (!$AuthorizationToken || !str_starts_with($AuthorizationToken, "Bearer ")) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid authorization header'
            ], 401);
        }

        // eksrak token
        $token = substr($AuthorizationToken, 7);

        // cek jika ada token yang cocok di database
        $accessToken = PersonalAccessToken::findToken($token);

        // validasi token
        if (!$accessToken || !$accessToken->tokenable) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid or expired'
            ], 401);
        }

        $user = $accessToken->tokenable;
        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
