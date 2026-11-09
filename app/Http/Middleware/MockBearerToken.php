<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk validasi Bearer Token.
 * Mendukung mode mock (string token tiruan) dan mode real (verifikasi JWT HS256 milik F-1 beserta hak akses peran).
 */
class MockBearerToken
{
    private const ALLOWED_ROLES = ['PM', 'ADMIN', 'COO', 'CTO'];

    public function handle(Request $request, Closure $next): Response
    {
        $given = (string) $request->bearerToken();

        if ($given === '') {
            return response()->json([
                'code' => 'UNAUTHENTICATED',
                'message' => 'Token tidak ada atau tidak valid.',
            ], 401);
        }

        // Mode nyata: validasi signature JWT HS256 dari F-1
        if (config('services.f1.mode') === 'real') {
            $payload = $this->verifyJwt($given, (string) config('services.f1.jwt_secret'));

            if ($payload === null) {
                return response()->json([
                    'code' => 'UNAUTHENTICATED',
                    'message' => 'Token JWT F-1 tidak valid atau telah kedaluwarsa.',
                ], 401);
            }

            $role = (string) ($payload['roleCode'] ?? '');
            if (! in_array($role, self::ALLOWED_ROLES, true)) {
                return response()->json([
                    'code' => 'FORBIDDEN',
                    'message' => 'Peran pengguna ('.$role.') tidak memiliki hak akses ke modul perencanaan proyek.',
                ], 403);
            }

            // Simpan data akun pada request agar dapat diakses controller bila diperlukan
            $request->attributes->set('f1_account', $payload);

            return $next($request);
        }

        // Mode tiruan (mock): cocokkan dengan konfigurasi mock_token
        $expected = (string) config('services.auth.mock_token');
        if (! hash_equals($expected, $given)) {
            return response()->json([
                'code' => 'UNAUTHENTICATED',
                'message' => 'Token tidak ada atau tidak valid.',
            ], 401);
        }

        return $next($request);
    }

    /**
     * Memverifikasi token JWT HS256 dan masa berlakunya.
     * @return array<string, mixed>|null Payload jika valid, null jika tidak valid.
     */
    private function verifyJwt(string $token, string $secret): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $sigB64] = $parts;

        $expectedSig = hash_hmac('sha256', "{$headerB64}.{$payloadB64}", $secret, true);
        $providedSig = $this->base64UrlDecode($sigB64);

        if ($providedSig === null || ! hash_equals($expectedSig, $providedSig)) {
            return null;
        }

        $payloadJson = $this->base64UrlDecode($payloadB64);
        if ($payloadJson === null) {
            return null;
        }

        $payload = json_decode($payloadJson, true);
        if (! is_array($payload)) {
            return null;
        }

        // Periksa waktu kedaluwarsa (exp)
        if (isset($payload['exp']) && is_numeric($payload['exp']) && $payload['exp'] < time()) {
            return null;
        }

        return $payload;
    }

    private function base64UrlDecode(string $input): ?string
    {
        $remainder = strlen($input) % 4;
        if ($remainder > 0) {
            $input .= str_repeat('=', 4 - $remainder);
        }

        $decoded = base64_decode(strtr($input, '-_', '+/'), true);

        return $decoded !== false ? $decoded : null;
    }
}
