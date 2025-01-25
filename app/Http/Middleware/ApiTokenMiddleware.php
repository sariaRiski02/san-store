<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $apiToken = $request->header('Api-token');
        if ($apiToken !== env('API_TOKEN')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid API token'
            ], 401);
        }
        return $next($request);
    }
}
