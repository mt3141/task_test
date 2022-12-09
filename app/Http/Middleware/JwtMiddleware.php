<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    [
                        'type' => 'error',
                        'text' => 'Token is Invalid'
                    ]
                ],Response::HTTP_BAD_REQUEST);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    [
                        'type' => 'error',
                        'text' => 'Token in Expired'
                    ]
                ],Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json([
                    [
                        'type' => 'error',
                        'text' => 'Authorization Token not found'
                    ]
                ],Response::HTTP_BAD_REQUEST);
            }
        }
        return $next($request);
    }
}
