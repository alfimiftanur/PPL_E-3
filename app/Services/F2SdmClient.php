<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Klien API Modul F-2 (Master SDM & Tenaga Ahli): GET /api/v1/referensi/sdm/{employeeId} (API-K02-17).
 * Mengambil informasi profil pegawai kanonis (nama lengkap, jabatan, NIP) berdasarkan employeeId.
 */
class F2SdmClient
{
    private const FIELDS = [
        'employeeId',
        'nomorPegawai',
        'namaLengkap',
        'jabatanId',
        'namaJabatan',
        'statusKerja',
    ];

    public function isReal(): bool
    {
        return config('services.f2.mode') === 'real';
    }

    /**
     * Mengambil data referensi SDM berdasarkan employeeId.
     * @return array{ok: bool, status: int|null, code: string|null, employee: array<string, mixed>|null}
     */
    public function find(string $employeeId): array
    {
        $url = rtrim((string) config('services.f2.base_url'), '/').'/referensi/sdm/'.rawurlencode($employeeId);

        try {
            $response = Http::acceptJson()
                ->withToken((string) config('services.f2.token'))
                ->timeout((int) config('services.f2.timeout', 3))
                ->get($url);
        } catch (ConnectionException $e) {
            Log::warning('F-2 tidak terjangkau', ['url' => $url]);

            return $this->fail('F2_UNREACHABLE', null);
        }

        Log::info('F-2 GET SDM', ['url' => $url, 'status' => $response->status()]);

        if ($response->status() === 404) {
            return $this->fail('EMPLOYEE_NOT_FOUND', 404);
        }

        if (! $response->successful()) {
            return $this->fail('F2_ERROR', $response->status());
        }

        $body = $response->json();
        if (! is_array($body) || empty($body['employeeId'])) {
            return $this->fail('F2_INVALID_RESPONSE', $response->status());
        }

        return [
            'ok' => true,
            'status' => $response->status(),
            'code' => null,
            'employee' => Arr::only($body, self::FIELDS),
        ];
    }

    /**
     * @return array{ok: false, status: int|null, code: string, employee: null}
     */
    private function fail(string $code, ?int $status): array
    {
        return [
            'ok' => false,
            'status' => $status,
            'code' => $code,
            'employee' => null,
        ];
    }
}
