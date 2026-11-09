<?php

namespace Tests\Feature;

use App\Services\ProjectWorkflowService;
use Tests\TestCase;

/**
 * Pengujian integrasi modul F-1 (Identitas & Hak Akses):
 * Memvalidasi mekanisme mode mock dan mode real dengan verifikasi JWT HS256 serta otorisasi peran PM/Admin.
 */
class F1IntegrationTest extends TestCase
{
    private const SECRET = 'ganti-dengan-rahasia-acak-minimal-32-karakter';
    private const PROJECT_ID = '01924b1e-7f32-7a81-9b12-45e8a1234567';

    protected function setUp(): void
    {
        parent::setUp();
        app(ProjectWorkflowService::class)->resetState();
        config([
            'services.f1.mode' => 'real',
            'services.f1.jwt_secret' => self::SECRET,
        ]);
    }

    public function test_token_jwt_sah_f1_dengan_peran_pm_diterima(): void
    {
        $token = $this->createJwt(['roleCode' => 'PM', 'accountId' => 'acc-01']);

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => "Bearer {$token}",
        ])->assertOk();
    }

    public function test_token_jwt_sah_f1_dengan_peran_admin_diterima(): void
    {
        $token = $this->createJwt(['roleCode' => 'ADMIN', 'accountId' => 'acc-admin']);

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => "Bearer {$token}",
        ])->assertOk();
    }

    public function test_token_jwt_f1_dengan_peran_bukan_pm_ditolak_403(): void
    {
        $token = $this->createJwt(['roleCode' => 'EMPLOYEE', 'accountId' => 'acc-emp']);

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => "Bearer {$token}",
        ])->assertStatus(403)->assertJsonPath('code', 'FORBIDDEN');
    }

    public function test_token_jwt_f1_palsu_signature_salah_ditolak_401(): void
    {
        $token = $this->createJwt(['roleCode' => 'PM'], 'secret-salah-12345678901234567890');

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => "Bearer {$token}",
        ])->assertStatus(401)->assertJsonPath('code', 'UNAUTHENTICATED');
    }

    public function test_token_jwt_f1_kedaluwarsa_ditolak_401(): void
    {
        $token = $this->createJwt(['roleCode' => 'PM', 'exp' => time() - 3600]);

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => "Bearer {$token}",
        ])->assertStatus(401)->assertJsonPath('code', 'UNAUTHENTICATED');
    }

    public function test_permintaan_tanpa_token_pada_mode_f1_real_ditolak_401(): void
    {
        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview')
            ->assertStatus(401)
            ->assertJsonPath('code', 'UNAUTHENTICATED');
    }

    public function test_mode_mock_tetap_menerima_mock_token(): void
    {
        config(['services.f1.mode' => 'mock']);

        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', [
            'Authorization' => 'Bearer mock-token',
        ])->assertOk();
    }

    private function createJwt(array $claims, string $secret = self::SECRET): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload = array_merge([
            'accountId' => '01929b4a-a123-7f77-9e34-2b3c4d5e6f70',
            'roleCode' => 'PM',
            'iat' => time(),
            'exp' => time() + 3600,
        ], $claims);

        $headerB64 = $this->base64Url(json_encode($header));
        $payloadB64 = $this->base64Url(json_encode($payload));
        $sig = hash_hmac('sha256', "{$headerB64}.{$payloadB64}", $secret, true);
        $sigB64 = $this->base64Url($sig);

        return "{$headerB64}.{$payloadB64}.{$sigB64}";
    }

    private function base64Url(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
