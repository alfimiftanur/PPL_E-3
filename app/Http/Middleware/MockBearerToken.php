<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for validating incoming bearer tokens against the configured mock token.
 */
class MockBearerToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.auth.mock_token');
        $given = (string) $request->bearerToken();

        if ($given === '' || ! hash_equals($expected, $given)) {
            return response()->json([
                'code' => 'UNAUTHENTICATED',
                'message' => 'Token tidak ada atau tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
