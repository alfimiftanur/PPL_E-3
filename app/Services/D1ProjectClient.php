<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Klien API 7 milik D-1: GET /api/v1/projects/{projectId} (API-K01-07).
 * Hanya field yang dibutuhkan E-3 yang diambil; indicativeValue dan auditLogs sengaja dibuang.
 */
class D1ProjectClient
{
    private const FIELDS = ['projectId', 'canonicalCode', 'projectName', 'clientName', 'pmEmployeeId', 'pmName', 'status', 'active', 'amName'];

    public function isReal(): bool
    {
        return config('services.d1.mode') === 'real';
    }

    /** @return array{ok: bool, status: int|null, code: string|null, project: array|null} */
    public function find(string $projectId): array
    {
        $url = rtrim((string) config('services.d1.base_url'), '/').'/projects/'.rawurlencode($projectId);

        try {
            $response = Http::acceptJson()
                ->withToken((string) config('services.d1.token'))
                ->timeout((int) config('services.d1.timeout'))
                ->get($url);
        } catch (ConnectionException $e) {
            Log::warning('D-1 tidak terjangkau', ['url' => $url]);

            return $this->fail('D1_UNREACHABLE', null);
        }

        // Jejak sisi E-3 untuk bukti (token tidak dicatat).
        Log::info('D-1 GET', ['url' => $url, 'status' => $response->status()]);

        if ($response->status() === 404) {
            return $this->fail('PROJECT_NOT_FOUND', 404);
        }

        if (! $response->successful()) {
            return $this->fail('D1_ERROR', $response->status());
        }

        $body = $response->json();
        if (! is_array($body) || empty($body['projectId'])) {
            return $this->fail('D1_INVALID_RESPONSE', $response->status());
        }

        return ['ok' => true, 'status' => $response->status(), 'code' => null, 'project' => Arr::only($body, self::FIELDS)];
    }

    private function fail(string $code, ?int $status): array
    {
        return ['ok' => false, 'status' => $status, 'code' => $code, 'project' => null];
    }
}
