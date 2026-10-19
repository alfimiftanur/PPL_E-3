<?php

namespace Tests\Feature;

use Tests\TestCase;

/** Memastikan respons sama dengan berkas di examples/ (yang juga dipakai openapi.yaml). */
class ApiContractTest extends TestCase
{
    private const READY = '01924b1e-7f32-7a81-9b12-45e8a1234567';
    private const NO_KICKOFF = '01924b1e-7f32-7a81-9b12-45e8a1234568';
    private const UNKNOWN = '01924b1e-7f32-7a81-9b12-45e8a9999999';

    private function example(string $file): array
    {
        return json_decode(file_get_contents(base_path("examples/$file")), true, 512, JSON_THROW_ON_ERROR);
    }

    private function api(string $id, string $path, bool $auth = true)
    {
        $headers = $auth ? ['Authorization' => 'Bearer mock-token'] : [];

        return $this->getJson("/api/v1/projects/$id/$path", $headers);
    }

    public function test_api01_200_siap(): void
    {
        $this->api(self::READY, 'execution-readiness')->assertOk()->assertExactJson($this->example('success.json'));
    }

    public function test_api01_200_tanpa_kickoff_dan_mom(): void
    {
        $this->api(self::NO_KICKOFF, 'execution-readiness')->assertOk()->assertExactJson($this->example('success-no-mom.json'));
    }

    public function test_api01_404(): void
    {
        $this->api(self::UNKNOWN, 'execution-readiness')->assertNotFound()->assertExactJson($this->example('error.json'));
    }

    public function test_api01_400_bukan_uuid_v7(): void
    {
        $this->api('TIDAK-ADA', 'execution-readiness')->assertStatus(400)
            ->assertJsonPath('code', 'INVALID_PROJECT_ID_FORMAT')
            ->assertJsonStructure(['code', 'message', 'details']);
    }

    public function test_api01_401_tanpa_token(): void
    {
        $this->api(self::READY, 'execution-readiness', false)->assertUnauthorized()->assertJsonPath('code', 'UNAUTHENTICATED');
    }

    public function test_api02_200_lengkap(): void
    {
        $this->api(self::READY, 'planning-references')->assertOk()->assertExactJson($this->example('planning-references.json'));
    }

    public function test_api02_200_kosong_baseline_draft_tidak_tampil(): void
    {
        $this->api(self::NO_KICKOFF, 'planning-references')->assertOk()->assertExactJson($this->example('planning-references-empty.json'));
    }

    public function test_api02_404(): void
    {
        $this->api(self::UNKNOWN, 'planning-references')->assertNotFound()->assertExactJson($this->example('error.json'));
    }

    public function test_api02_400_bukan_uuid_v7(): void
    {
        $this->api('TIDAK-ADA', 'planning-references')->assertStatus(400)->assertJsonPath('code', 'INVALID_PROJECT_ID_FORMAT');
    }

    public function test_api02_401_tanpa_token(): void
    {
        $this->api(self::READY, 'planning-references', false)->assertUnauthorized();
    }
}
