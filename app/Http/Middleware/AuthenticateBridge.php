<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateBridge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = config('app.bridge_api_key', env('BRIDGE_API_KEY'));

        if (!$apiKey) {
            // If no key is configured, fail secure
            return response()->json(['error' => 'Server misconfiguration'], 500);
        }

        if ($request->header('X-API-KEY') !== $apiKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
