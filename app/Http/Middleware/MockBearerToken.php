<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pengganti sementara validasi token F-1 (API-F1-02/API-F1-05).
 * Hanya menerima token tiruan dari MOCK_TOKEN. Metode final menunggu keputusan OPEN-02.
 */
class MockBearerToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.e3.mock_token');
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
